
# CSV Upload

A program that allows a user to upload a csv.

The backend then takes that csv and parses the data to create a record for each person.

For example a row in the csv could contain 
"Mr & Mrs Smith"

These would be split and two records would be created
1. "Mr Smith"
2. "Mrs Smith"



## Run Locally

Clone the project

```bash
  git clone https://github.com/conorholgate/csv-upload
```

Go to the project directory

```bash
  cd csv-upload
```

Install dependencies

```bash
  npm install
  composer install
```

Start the server

```bash
  php artisan serve & npm run dev
```

