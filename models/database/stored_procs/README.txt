READ ME....

-------------Loading stored procedures into the database--------------------
Run each of the .sql files on the MySQL database server in order to populate
the database with these procedures.


--------------------------Using procedures in php----------------------------

Note:  There has been no need to use OUTS in procedures thus far,
should the need arise that will complicate things greatly, for now this
will only cover how to use procedures with one IN parameter.

1.Simply establish a variable as a query essentially, except you use the 
CALL function to the call the procedure as it is named in the SQL database

2.For example if we have the procedure:

CREATE PROCEDURE `getOrginization` (IN orginizationIdp int)



BEGIN


SELECT organizationName


FROM organizations


WHERE organizationid = organizationIdp;



END//

in your PHP code you would type:

 $result = mysqli_query($connection, 
     "CALL getOrganization(1)") or die("Query fail: " . mysqli_error());

3.The $result variable will now contain the results of
the query contained within the stored procedure!

