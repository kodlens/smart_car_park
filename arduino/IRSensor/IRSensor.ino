#include<Servo.h>
#include <ESP8266WiFi.h>
#include <ESP8266WebServer.h>

//declaration for servo
Servo gate;
static const uint8_t D0   = 16;
static const uint8_t D1   = 5;
static const uint8_t D2   = 4;
static const uint8_t D3   = 0;
static const uint8_t D4   = 2;
static const uint8_t D5   = 14;
static const uint8_t D6   = 12;
static const uint8_t D7   = 13;
static const uint8_t D8   = 15;
static const uint8_t RX   = 3;
static const uint8_t TX   = 1;


//output for servo
int servoPin = D4;
//int servoPin = 2;

//output for IR
int IR1 = D1;
//int IR = 5;

//new sensor, for closing the gate after car exited
int IR2 = D2;


String parkId = "";
int msg = 0;

//wifi name and password
const char* ssid = "One Piece";
const char* password = "Airjordan*23";

IPAddress staticIP(192, 168, 1, 40); // Set the desired static IP address
//Default gateway
IPAddress gateway(192, 168, 1, 1); // Set your router's gateway IP address


IPAddress subnet(255, 255, 255, 0); // Set your subnet mask
WiFiServer server(80); // Port 80 for HTTP

void setup() {

  //baud frequency
  Serial.begin(9600);
  WiFi.begin(ssid, password);
  server.begin();

  //WIFI CONNECTION
  if(!WiFi.config(staticIP, gateway, subnet)){
    Serial.println("Failed to Setup ipconfigs");
  };


  Serial.println("Connecting to Wi-Fi");
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.println("Connecting to WiFi...");
  }
  Serial.println("Connected to WiFi");

  //for the IR (sending input)
  pinMode(IR1, INPUT);
  pinMode(IR2, INPUT);

  //for the SERVO (sending input)
  gate.attach(servoPin);
  gate.write(0);

}
int IRState1 = 1; //set wala sakyanan
int IRState2 = 1; //set wala sakyanan
bool isToExecuteToPark = false;
bool isToExecuteExit = false;
int counter = 0;


void loop() {
  Serial.println("Waiting Request...");
  WiFiClient client = server.available();
  
  IRState1 = digitalRead(IR1);
  IRState2 = digitalRead(IR2); //exit sensor

  Serial.println("--------SENSOR STATE---------");
  Serial.print("IR SENSOR 1: ");
  Serial.println(IRState1);

  Serial.print("IR SENSOR 2: ");
  Serial.println(IRState2);
  Serial.println("--------END SENSOR STATE---------");


  if(isToExecuteToPark == true){
    Serial.println("-------EXECUTE TO PARK IS TRUE----------");

    if(IRState1 == 0){ //dapat naa koi makita nga sakyanan
      Serial.println("-------EXECUTE TO PARK----------");
      Serial.println("Vehicle Detected to Park!");  
      delay(5000);
      gate.write(0); //close the gate
      Serial.println("Servo close!");  
      Serial.println("--------END EXECUTE TO PARK---------");
      isToExecuteToPark = false;
    }
  }

  /* IR 0 means there is an object detect in front of the device */
  if(isToExecuteExit == true){
    Serial.println("-------EXECUTE TO EXIT IS TRUE (waiting for the ir1 and ir2)----------");
    
    if(IRState1 == 1 && IRState2 == 1){ //dapat wala ang sakyanan 3 sec before mo close ang gates
      Serial.println("--------START EXIT PROCEDURE---------");
      Serial.println("Vehicle Detected to move out!");  
      delay(3000);
      gate.write(0); //close the gate
      Serial.println("Servo close!");  
      isToExecuteExit = false;
      Serial.println("-------SETTING TO EXECUTE TO FALSE----------");
      Serial.println("---------END EXI PROCEDURE--------");
    }

    // if(IRState2 == 0){ //dapat wala ang sakyanan 10 sec before mo close ang gates
    //   delay(3000);
    //   //gate.write(0); //close the gate
    //   //isToExecuteExit = false;
    // }

  }
  

  String request = client.readStringUntil('\r');
  if (request.indexOf("/enter") != -1)
  {
    Serial.println("--------DETECT ENTER---------");
    isToExecuteToPark = true;
    msg = 1;
    gate.write(180); //open gate
    Serial.println("Servo open!");  
    Serial.println("--------END ENTER---------");


  }//end if

  if (request.indexOf("/exit") != -1)  
  {
    Serial.println("--------DETECT EXIT---------");
    isToExecuteExit = true;
    msg = 0;
    gate.write(180);
    Serial.println("Servo open!");  
    Serial.println("--------END EXIT---------");

  }//end if


  /* ========== FOR SERVO TESTING ========== */
  if (request.indexOf("/close") != -1)  
  {
    Serial.println("--------DEBUG CLOSE---------");
    gate.write(0);
    Serial.println("Servo close!");  
    Serial.println("--------END DEBUG CLOSE---------");


  }//end if

  if (request.indexOf("/open") != -1)  
  {
    Serial.println("--------DEBUG OPEN---------");
    gate.write(180);
    Serial.println("Servo open!");  
    Serial.println("--------END DEBUG OPEN---------");
  }//end if
 /* ========== FOR SERVO TESTING ========== */



  client.println("HTTP/1.1 200 OK");
  client.println("Content-Type: text/html");
  //client.println("Content-Type: application/json");
  client.println("Access-Control-Allow-Origin: *");

  client.println("");

  client.flush();
  delay(100);

}
