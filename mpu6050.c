#include <mysql.h>
#include <wiringPi.h>
#include <wiringPiI2C.h>
#include <stdio.h>
#include <stdlib.h>
#include <stdint.h>  //int16_t 
#include <math.h>    // gcc ..... -l wiringPi -lm
#define Sample_rate 25
#define Config      26
#define Gyro_config 27
#define Acc_config  28
#define Interrupt   56
#define PWR_managment 107
#define Acc_X       59
#define Acc_Y       61
#define Acc_Z       63
int mpu;
float data;
int16_t a,b,c,d,e,LSB;
void Init_6050(void)
{
//register 25 ->28,56,107
wiringPiI2CWriteReg8(mpu,Sample_rate,a);
wiringPiI2CWriteReg8(mpu,Config,b);
wiringPiI2CWriteReg8(mpu,Gyro_config,c);
wiringPiI2CWriteReg8(mpu,Acc_config,d);
wiringPiI2CWriteReg8(mpu,Interrupt,e);
wiringPiI2CWriteReg8(mpu,PWR_managment,0x01);
}

int16_t read_sensor(unsigned char sensor)
{
    int16_t high,low,data;
    high = wiringPiI2CReadReg8(mpu,sensor);
    low = wiringPiI2CReadReg8(mpu,sensor+1);
    data = (high<<8) | low;
    return data;
}
int16_t read_Gyro(unsigned char address)
{
    int16_t data;
    data = wiringPiI2CReadReg8(mpu, address);
    data = data;
    return data;
}
int main(void)
{
    mpu = wiringPiI2CSetup(0x68);
    //setup gieo tiep i2c
    wiringPiSetupPhys();
    //detup SPI interface
    //wiringPiSPISetup(channel, 8000000);  //spi0 , clock speed = 8MHz
    //thiet lap che do cho MPU
    Init_6050();

    //////
    MYSQL *conn;
    MYSQL_RES *res;
    MYSQL_ROW row;
    char *server = "localhost";
    char *user = "nkhoi"; // Your name user SQL
    char *password = "1"; // Your name password SQL
    char *database = "sensor"; // Your name databse

    //đọc các giá trị đo
    while (1)
    {
        // Gui len database table thuthap
        conn = mysql_init(NULL);
        mysql_real_connect(conn,server,user,password,database,0,NULL,0);

        float Ax = (float)read_sensor(Acc_X)/LSB;
        float Ay = (float)read_sensor(Acc_Y)/LSB;
        float Az = (float)read_sensor(Acc_Z)/LSB;
        
        float pitch = atan2(Ax,sqrt(pow(Ay,2)+pow(Az,2)))*180/M_PI;
        float roll = atan2(Ay,sqrt(pow(Ax,2)+pow(Az,2)))*180/M_PI;
        //float tinhtien_Ax = 
        printf("Gia tri roll :%.1f\n",roll);
        printf("Gia tri pitch :%.1f\n",pitch);
        delay(1000);

        char cmd[200];
        sprintf(cmd,"insert into thuthap(roll,pitch) values (%.2f,%.2f)",roll,pitch);

        // send SQL query
        mysql_query(conn, cmd);

        // Lay tu table thietlap
        mysql_query(conn, "select * from thietlap");
        res = mysql_store_result(conn);
        int num_column = mysql_num_fields(res);

        

        while (row = mysql_fetch_row(res))
        {
            printf("Thiet lap : %d \t %d \t %d \t %d \t %d \n\n",atoi(row[0]), atoi(row[1]),atoi(row[2]),atoi(row[3]),atoi(row[4]));
            //Sample Rate
            if(atoi(row[0])==260) { a = 8000/atoi(row[0]) - 1; }
            else{ a = 1000/atoi(row[0]) - 1; }

            //Config
            b = atoi(row[1]);
            if(b==260){ b=0x00; }
            if(b==184){ b=0x01; }
            if(b==94 ){ b=0x02; }
            if(b==44 ){ b=0x03; }
            if(b==21 ){ b=0x04; }
            if(b==10 ){ b=0x05; }
            if(b==5  ){ b=0x06; }
            if(b==3  ){ b=0x07; }

            //Gyro_config
            c = atoi(row[3]);
            if(c==250 ){ c=0xE0; }
            if(c==500 ){ c=0xE8; }
            if(c==1000){ c=0xF0; }
            if(c==2000){ c=0xF8; }

            //Acc_config
            d = atoi(row[2]);
            if(d==2 ){ d=0x00; LSB=16384;}
            if(d==4 ){ d=0x08; LSB=8192; }
            if(d==8 ){ d=0x10; LSB=4096; }
            if(d==16){ d=0x18; LSB=2048; }

            //Interrupt
            e = atoi(row[4]);

        }
        // clear result and close the connection
        // printf("Gia tri LSB : %d \n",LSB);
        // printf("Gia tri Ax : %f \n",Ax);
        // printf("Gia tri Ay : %f \n",Ay);
        // printf("Gia tri Az : %f \n\n",Az);

        mysql_free_result(res);

    }
    mysql_close(conn);
    return 0;
}
