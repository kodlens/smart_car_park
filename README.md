# SMART CAR PARK
This is application used Web and a hardware called ESP8266. This project is a car parking application
which you can make reservation on a specific car parking area. This will also cater online payment such as
GCASH, Bank Payments etc... depending on the payment gateway. The payment gateway used in this application is PAYMONGO.


## For chart js
    install this version
    "chart.js": "^3.8.0",
    "vue-chartjs": "^4.0.0"

## For VUE Version
     "vue": "^2.7.16",


## Update instruction
Open git bash and run this command

    git pull


There are updates on the structure of database so we need to refresh all database structure
and this action will delete all data on the database and will re populate with newer data.

    php artisan migrate:refresh --seed


## Update Notes
- Dashboard Graph
- Reports (Monthly and Weekly reports)
- Dynamically adding and editing Park Module (ESP8266 Device)