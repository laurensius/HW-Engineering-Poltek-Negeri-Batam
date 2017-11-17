#include <DHT.h>
#include <Ethernet.h>
#include <SPI.h>

#define DHTPIN 2
#define DHTTYPE DHT11
#define STATUS_DISCONNECTED 0
#define STATUS_CONNECTED 1 

boolean startRead = false;
int temp,rh;
int iterasi = 1;
int detik = 0;
int menit = 0;
char inString[32];
char charFromWeb[9];
char namaServer[] = "192.168.1.111";
byte IP_eth[] = {192,168,1,112};
byte MAC_eth[] = { 0xDE, 0xAD, 0xBE, 0xEF, 0xFE, 0xED };

IPAddress ip(192, 168, 1, 115);
EthernetClient myEthernet;
DHT dht(DHTPIN, DHTTYPE);

void setup() {
  Serial.println("--------------------------------------------------"); 
  Serial.println("Setting Perangkat");
  Serial.println("Mohon menunggu . . . ");
  Serial.println("Setting Ethernet MAC Address dan IP Address");
  Serial.println("Mohon menunggu . . . ");
  Serial.begin(9600);
  dht.begin();
  if (Ethernet.begin(MAC_eth) == 0) {
    Serial.println("Failed to configure Ethernet using DHCP");
    Ethernet.begin(MAC_eth,IP_eth);
  }
  Serial.println("Setting Perangkat selesai!");
  Serial.println("--------------------------------------------------");
}

void loop() {
  if(detik < 59){
      detik++;
  }else{
      detik = 0;
      if(menit < 4){
        menit++;
      }else{
        menit = 0;
        Serial.print("Iterasi ke : ");
        Serial.println(iterasi);
        String sensor_data = baca_sensor();
        int resultBukaKoneksi = bukaKoneksi();
        if(resultBukaKoneksi==1){
            kirimData(sensor_data);
            Serial.println();
        }
        Serial.println("--------------------------------------------------");
        iterasi++;
      }
  }
  Serial.print(menit);
  Serial.print(" menit - ");
  Serial.print(detik);
  Serial.println(" detik");
  delay(1000);
}

String baca_sensor(){
  String url_segment = "";
  rh = (int) dht.readHumidity();
  temp = (int) dht.readTemperature();
  String x = String(temp);
  String y = String(rh);
  url_segment = "?suhu=" + x  + "&rh=" + y; 
  return url_segment;
}

int bukaKoneksi(){
  Serial.print("Mencoba sambungan ke server http://"); 
  Serial.println(namaServer);  
  Serial.println("Mohon menunggu . . . ");
  if(myEthernet.connect(namaServer,80)){
    Serial.println("Sambungan ke server berhasil!");
    return STATUS_CONNECTED; 
  }else{
    Serial.print("Sambungan ke server gagal!");
    Serial.println();
    return STATUS_DISCONNECTED;
  }
}

void kirimData(String data){
    Serial.println("Menjalankan perintah kirim data");
    int ln = data.length();
    String uri_segment;
    uri_segment = "/monitoring/simpan_data.php" + data;
    myEthernet.print("GET ");
    myEthernet.print(uri_segment); 
    Serial.print("Data yang dikirim di ke server : ");
    Serial.println(data);
    myEthernet.println(" HTTP/1.1 ");
    myEthernet.print( "Host : " );
    myEthernet.println(" 192.168.1.111 \r\n");
    Serial.println("Host OK");
    myEthernet.println( "Content-Type: application/x-www-form-urlencoded \r\n" );
    Serial.println("Content type OK");
    myEthernet.print( "Content-Length : " );
    myEthernet.print(ln);
    myEthernet.print(" \r\n");
    myEthernet.println( "Connection: close" );
    myEthernet.println();
    String result = bacaWebText();
    Serial.println(result);
//------------warning selalu tutup koneksi ya........
    myEthernet.stop();
    myEthernet.flush();
//--------------------------------------------------
}

String bacaWebText(){
  unsigned int time;
  Serial.println("Baca respon dari server . . . "); 
  Serial.println("Mohon menunggu . . . ");
  time = millis();
  Serial.print("Timer Millis () : ");
  Serial.println(time);
  int stringPos = 0;
  memset( &inString, 0, 32 );
  int unvailable_ctr = 0;
  while(true){
    if (myEthernet.available()) {
      char c = myEthernet.read();
      Serial.print(c);
      if (c == '#' ) { 
        Serial.print("Menemukan start key # dengan isi : ");
        startRead = true;  
      }else if(startRead){
        if(c != '^'){ 
          inString[stringPos] = c;
          stringPos ++;
        }else{
          startRead = false;
          Serial.println();
          Serial.println("Baca respon dari server selesai!");
          myEthernet.stop();
          myEthernet.flush();
          Serial.println("Sambungan diputuskan . . . ");
          return inString;
        }
      }
    }else{
       //Serial.println("ethernet unavailable");
       delay(50);
       unvailable_ctr++;
       if(unvailable_ctr == 25){
         myEthernet.stop();
         myEthernet.flush();
         Serial.println("Koneksi mengalami time out");
         Serial.println("Sambungan diputuskan . . . ");
         Serial.println("Reset...");
         return inString;
       }
    }
  }
}
