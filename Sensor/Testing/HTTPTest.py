import requests

print("Hello world! Welkom bij de ToiletSchoonhouder :)")
# De URL van de server waar je het bestand naar wilt sturen
URL = 'https://informatica.ghlyceum.nl/users/39506/PHP/PWS/SchadeFormulier/DBHandler.php'

# Gegevens die je wilt versturen via het formulier
DATA = {
    'ToiletID': '0M',           # Toilet ID, vervang door het juiste ID
    'Source': 'Formulier',         # Of 'Sensor', afhankelijk van de bron
    'Validity': 'Eerlijk',            # Betrouwbaarheid, bijvoorbeeld 'Onbetrouwbaar', 'Eerlijk', 'Betrouwbaar'
    'Description': 'Er is een probleem met de toiletdoorgang',  # Beschrijving
}
# Open het bestand in binaire modus en stuur het via een POST-verzoek
with open("./Test.png", 'rb') as File:
    FILE = {'file': File}

# Verstuur het POST-verzoek
response = requests.post(url, data=DATA, files=FILE)

# Controleer de reactie van de server
if response.status_code == 200:
    print("De gegevens zijn succesvol verzonden!")
else:
    print(f"Er is een fout opgetreden. Statuscode: {response.status_code}")
