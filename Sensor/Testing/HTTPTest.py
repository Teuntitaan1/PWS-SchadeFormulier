import requests
import mimetypes

print("Hello world! Welkom bij de ToiletSchoonhouder :)")

# De URL van de server waar je het bestand naar wilt sturen
URL = 'https://informatica.ghlyceum.nl/users/39506/PHP/PWS/SchadeFormulier/DBHandler.php'
# Gegevens die je wilt versturen via het formulier
DATA = {
    'ToiletID': '0M',           # Toilet ID, vervang door het juiste ID
    'Source': 'Sensor',         # Of 'Sensor', afhankelijk van de bron
    'Validity': 'Eerlijk',            # Betrouwbaarheid, bijvoorbeeld 'Onbetrouwbaar', 'Eerlijk', 'Betrouwbaar'
    'Description': 'Skibidi file test',  # Beschrijving
}
FileUrl = "Test.mp4"
# Open het bestand in binaire modus en stuur het via een POST-verzoek
with open(FileUrl, 'rb') as File:
    FILE = {'Evidence': (File.name, File)}
    # Verstuur het POST-verzoek
    Request = requests.post(URL, data=DATA, files=FILE)



