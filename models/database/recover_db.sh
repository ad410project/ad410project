#!/bin/bash

# To use:
# ./recover_db backup_filename.sql
# If no file is passed to the script, it will
# recover using the most recent backup.

# Database credentials
user=""
password=""
host="localhost"
db_name="mydb"

# Path/filename options
backup_path="/home/backups/db"

# Get filename from command options
if [$1]; then
	fileName=$1
	echo "Restoring database from $fileName."
else
	echo "No backup file selected. Restoring from most recent backup."
	fileName=$(ls -t | head -n1)
fi

# Run SQL script on SQL server
mysql --user=$user --password=$password --host=$host $db_name > $backup_path/$fileName
	