#!/bin/bash

# To use:
# ./recover_db backup_filename.sql
# If no file is passed to the script, it will
# recover using the most recent backup.

# Database credentials
user=""
password=""
host=""
db_name="mydb"

# Path/filename options
backup_path="/home/bitnami/backups/db"

# Get filename from command options
if [$1]; then
        fileName=$1
        echo "Restoring database from $fileName."
else
        echo "No backup file selected. Restoring from most recent backup."
        fileName=$(ls -t *.sql | head -n1)
fi

# Run SQL script on SQL server
# First check if database exists. If not, create it.
if ! mysql --user=$user --password=$password --host=$host -e 'use $db_name' 2> /dev/null; 
then
        echo "Database not found. Recreating schema."
        mysqladmin CREATE $db_name --user=$user --password=$password --host=$host
fi

mysql --user=$user --password=$password --host=$host $db_name < $backup_path/$fileName