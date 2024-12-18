#include "Adafruit_SGP30.h"
#include "Adafruit_SHT4x.h"

// Variablen
// Minimale waardestijging voordat ie iets meldt.
float TemperatureThreshold = 1.0;       // Minimale temperatuurstijging (°C)
float HumidityThreshold = 5.0;        // Minimale luchtvochtigheidsstijging (%)
int VOCThreshold = 100;          // VOC-drempelwaarde (afhankelijk van sensor, meestal in ppm)

// Variabelen voor basismeting
float BaseTemperature = 0.0;
float BaseHumidity = 0.0;
int BaseVOC = 0;

// Sensoren
Adafruit_SHT4x HT_Sensor;
Adafruit_SGP30 VOC_Sensor;

void setup() {
  Serial.begin(9600);
  // Humidity en Temperature Sensor activeren
  HT_Sensor.begin();
  VOC_Sensor.begin();

  // HT Sensor functionaliteit
  sensors_event_t Humidity, Temperature;
  HT_Sensor.getEvent(&Humidity, &Temperature); // Vul de variablen met nieuwe data.
  BaseTemperature = Temperature.temperature;
  BaseHumidity = Humidity.relative_humidity;

  // Voc Sensor functionaliteit
  VOC_Sensor.setHumidity(getAbsoluteHumidity(BaseTemperature, BaseHumidity));
  // Verkrijgt VOC en CO2, we gebruiken VOC
  VOC_Sensor.IAQmeasure();
  BaseVOC = VOC_Sensor.TVOC;

}

void loop() {


  // ANTI VAPE FUNCTIONALITEIT
  // HT Sensor functionaliteit
  sensors_event_t Humidity, Temperature; HT_Sensor.getEvent(&Humidity, &Temperature); // Vul de variablen met nieuwe data.
  float RealTemperature = Temperature.temperature; float RealHumidity = Humidity.relative_humidity;

  // Voc Sensor functionaliteit
  VOC_Sensor.setHumidity(getAbsoluteHumidity(RealTemperature, RealHumidity));
  // Verkrijgt VOC en CO2, we gebruiken VOC
  VOC_Sensor.IAQmeasure();
  int CurrentVOC = VOC_Sensor.TVOC;

  // Veranderingen berekenen
  float DeltaTemperature = RealTemperature - BaseTemperature;
  float DeltaHumidity = RealHumidity - BaseHumidity;
  int DeltaVOC = CurrentVOC - BaseVOC;

  // Voorwaarden checken, Waarschijnlijk vapen
  if (DeltaTemperature >= TemperatureThreshold && DeltaHumidity >= HumidityThreshold && DeltaVOC >= VOCThreshold) {
    Serial.println("Er wordt gevaped!");
    // lange cooldown, waarden moeten weer dalen
    delay(5000);
  }
}

// Calibratie functie van de voc sensor 
uint32_t getAbsoluteHumidity(float temperature, float humidity) {
    const float absoluteHumidity = 216.7f * ((humidity / 100.0f) * 6.112f * exp((17.62f * temperature) / (243.12f + temperature)) / (273.15f + temperature)); // [g/m^3]
    const uint32_t absoluteHumidityScaled = static_cast<uint32_t>(1000.0f * absoluteHumidity); // [mg/m^3]
    return absoluteHumidityScaled;
}
