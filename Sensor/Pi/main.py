import serial, time, requests, datetime, os
from picamera2 import Picamera2

# Variablen
LastSentPost = time.time()
ToiletList = {
"0M" : "mannentoilet op de begane grond",
"0F" : "vrouwentoilet op de begane grond",
"1M" : "mannentoilet op de 1e verdieping",
"1F" : "vrouwentoilet op de 1e verdieping",
"2M" : "mannentoilet op de 2e verdieping",
"2F" : "vrouwentoilet op de 2e verdieping",
"3M" : "mannentoilet op de 3e verdieping",
"3F" : "vrouwentoilet op de 3e verdieping",
"0G" : "genderneutrale toilet",
}
SensorConfig = {
    "ServerUrl" : "https://informatica.ghlyceum.nl/users/39506/PHP/PWS/SchadeFormulier/DBHandler.php",
    "ToiledID" : "0M",
    "EvidenceName" : "Bewijs.mp4",
    "TakeEvidence" : True,
    "Delay" : 10
}

# Arduino connectie via serial, later via bluetooth. Stuurt commando's naar rapsberry pi om de database te updaten.
Arduino = serial.Serial('/dev/ttyACM0', 9600, timeout=1)
Arduino.reset_input_buffer()

# Camera connectie via bedrade camera aan Raspberry pi. Gebruikt om video's mee te maken en dit op te sturen.
Camera = Picamera2()

# Preset data die later aangepast wordt.
DATA = {
'ToiletID': SensorConfig['ToiledID'],           # Toilet ID, vervang door het juiste ID
'Source': 'Sensor',         # Of 'Sensor', afhankelijk van de bron
'Validity': 'NULL',            # Betrouwbaarheid, bijvoorbeeld 'Onbetrouwbaar', 'Eerlijk', 'Betrouwbaar'
'Description': 'NULL',  # Beschrijving
}

print(f"Welkom bij de schadesensor van het {ToiletList[SensorConfig['ToiledID']]}. Het programma is gestart op {datetime.date.today()}")

while True:
    # Commando verstuurd, er moet gereageerd worden.
    if Arduino.in_waiting > 0:
        Command = Arduino.readline().decode('utf-8').rstrip()

        ShouldSentPost = True
        # Cooldown om overbelasting te voorkomen
        if ((time.time() - LastSentPost) < 30):
            ShouldSentPost = False

        # Voer de juiste data door op basis van de ontvangen string
        match Command:
            case "Vaping_Low":
                DATA['Validity'] = "Onbetrouwbaar"
                DATA['Description'] = f"Er is mogelijk gevaped op het {ToiletList[SensorConfig['ToiledID']]}. Het kan het waard zijn hier even naar te kijken."
            case "Vaping_High":
                DATA['Validity'] = "Eerlijk"
                DATA['Description'] = f"Er is waarschijnlijk gevaped op het {ToiletList[SensorConfig['ToiledID']]}. Het is het zeker waard even te kijken."
            case "Vandalism_Low":
                DATA['Validity'] = "Onbetrouwbaar"
                DATA['Description'] = f"Er is mogelijk gevandaliseerd op het {ToiletList[SensorConfig['ToiledID']]}. Het kan het waard zijn hier even naar te kijken."
            case "Vandalism_High":
                DATA['Validity'] = "Eerlijk"
                DATA['Description'] = f"Er is waarschijnlijk gevandaliseerd op het {ToiletList[SensorConfig['ToiledID']]}. Het is het zeker waard even te kijken."
            case _:
                ShouldSentPost = False

        print(f"Commando {Command} ontvangen om {datetime.date.today()}")

        if ShouldSentPost:
            print("Een POST request aan het sturen.")

        # video functionaliteit
        if SensorConfig["TakeEvidence"]:
            # Wacht eventjes met het maken van een video zodat de daders beter gepakt worden
            time.sleep(SensorConfig["Delay"])
            
            Camera.start_and_record_video(SensorConfig["EvidenceName"], duration=5)
            time.sleep(10)
            # Open het bestand in binaire modus en stuur het via een POST-verzoek
            with open(SensorConfig["EvidenceName"], 'rb') as File:
                # Verstuur het POST-verzoek
                Request = requests.post(SensorConfig['ServerUrl'], data=DATA, files={'Evidence': (File.name, File)})
            # Verwijderd het bestand zodat de ruimte bespaart blijft
            os.remove(SensorConfig["EvidenceName"])

        else:
            Request = requests.post(SensorConfig['ServerUrl'], data=DATA)
            
        if Request.status_code == 200:
            print("Met succes een POST request gestuurd")
        else:
            print("Zonder succes een POST request gestuurd")
