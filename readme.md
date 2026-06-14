**Parking Management System Design**
This system is meant to only be used by parking area staff. There are NO customer accounts involved.
___
### Database Layout

TABLE NAME: **accounts**

*All the employee accounts.*
- **acc_id** [ int(255), auto_increment, primary key ]
- **name** [ varchar(255) ]
- **email** [ varchar(255) ]
- **password** [ varchar(255) ]
- **acc_type** [ enum(EMPLOYEE, ADMIN) ]

TABLE NAME: **parking**

*A record of the parking spaces themselves.*
- **spot_id** [ int(255), auto_increment, primary key ]
- **spot_name** [ varchar(255), unique ]  > *NOTE: This is labeled A1, A2, B1, B2, etc...* <
- **status** [ enum(OPEN, TAKEN) ]

TABLE NAME: **vehicles**

*This table records vehicles CURRENTLY in the parking spaces. If a vehicle leaves, their row will be deleted from this table.*
- **license_plate** [ varchar(255), primary key]
- **vehicle_name** [ varchar(255) ] > *NOTE: vehicle's model name* <
- **owner** [ varchar(255) ]
- **driver_license** [ varchar(255) ] > *NOTE: Not the image itself, just the filepath pointing to where the driver's license image is stored in our folders.* <
- **registration** [ varchar(255) ] > *NOTE: Same purpose as above, but for vehicle registration* <
- **current_spot** [ varchar(3), unique, (references spot_name from parking) ]
- **entry_time** [ datetime(), default to current datetime as of uploading ]

TABLE NAME: **history**

*This table records vehicles NOT CURRENTLY in the parking spaces. Essentially a transaction history. When a vehicle leaves, their row will be added to this table.*
- **license_plate** [ varchar(255), primary key ]
- **vehicle_name** [ varchar(255) ] > *NOTE: vehicle's model name* <
- **owner** [ varchar(255) ]
- **driver_license** [ varchar(255) ] > *NOTE: Not the image itself, just the filepath pointing to where the driver's license image is stored in our folders.* <
- **registration** [ varchar(255) ] > *NOTE: Same purpose as above, but for vehicle registration* <
- **entry_time** [ datetime()  ]
- **exit_time** [ datetime(), default to current datetime as of uploading ]
___
### Page Layout

PAGE NAME: **Login.php**

*Very first screen of the app, hence all operations will start here.*
- Has form input fields for email and password.
- Regex check will be performed for the email field upon the clicking of submission.
- Email and password validity will be checked via the **accounts** table in the database.
- Error message will appear at the bottom if password is incorrect or email is in the wrong format.

PAGE NAME: **TableView.php**

*A tabular view of all the parking spaces, their status, and availability*.
- Will contain an html-made table with the following fields: **Spot ID**, **Spot Name**, **Status**, **License Plate**, **Vehicle Name**, **Owner**, **Entry Time**, ***Actions***.
- To get the data for that table, a query which joins the results of **parking** and **vehicles** will be used. All the parking spots from **parking** MUST appear.
- If a parking spot has its status set to "OPEN" or its *spot_id* isn't in **vehicles**, then its data for the **License Plate**, **Vehicle Name**, **Owner**, **Entry Time**, ***Actions*** will be set to "N/A" automatically.
- The ***Actions*** column is only available for rows with their status set to "TAKEN". It displays 2 main buttons: a **check mark** and **3 vertical dots**. The *check mark* sends the row's data to the **history** table and deletes it from the **vehicles** table, then refreshes the page. The *3 vertical dots* acts as an options menu with the following options: *view driver's license*, *view vehicle registration*, *edit*, *delete*
- The table is paginated and will only display 10 rows per page.
- Driver's license and registration will be deleted from files upon pressing the checkbox.
- Has a green "new vehicle" button for recording new vehicles.

PAGE NAME: **TransactionHistory.php**

*Displays the details of the history table in the database*
- Has a table with the following columns: **License Plate**, **Vehicle Name**, **Owner**,  **Spot**, **Entry Time**, **Exit Time**.
- The data for the table can be obtained by performing an SQL query on the **history** table.
- The table is paginated and will only display 10 rows per page.

PAGE NAME: **AddVehicle.php**

*The page that appears when you press the "add" button in TableView.php*

- Has form input fields for the following: **Owner Name**, **License Plate**, **Vehicle Name**, a dropdown / combobox for **Parking Spot**, and upload fields for **Driver's License** and **Vehicle Registration**.
- The **spot** dropdown only allows spots that are marked as "OPEN" to be picked.
- The **Driver's License** and **Vehicle Registration** will be saved to our files NOT THE DATABASE. What gets pushed to the database is the file path pointing to the driver's license and vehicle registration (Example: "Files/Licenses/JohnDoe.png").

PAGE NAME: **EditVehicle.php**

*The editing page that appears when you press the "edit" option in TableView.php*

- Exact same layout as *Add.php* but with only the option to edit **Owner Name**, **License Plate**, **Vehicle Name**, and upload fields for **Driver's License** and **Vehicle Registration**.
- When you load the page after pressing edit, the current values of the row you're editing should be reflected on the form input fields.

PAGE NAME: **SpotManagement.php**

*Page for managing the different parking spots themselves.*

- Has a table with the following columns: **ID**, **Name**, **Status**.
- Data for this table is obtained by querying all the rows and columns of the **parking** table.
- Above a table is a form input field with a button to the right. The button says "Add Parking Spot" and adds a new parking spot if something is typed on the text field to the left.
- Regex confirmation needs to be run on the form input field when inputting a new parking spot. It needs to check for a a SINGLE capital letter and any digit (1-99).

PAGE NAME: **ManageAccounts.php**

*Account management page for admins to use*

- Only accessible by admins.
- Has a table with the following columns: **Account ID**, **Name**, **Email**, **Account Type**, and **Ac	tions**.
- Has a button above the table labeled "Add Account".
- The **Actions** menu has a button for deleting an account.

PAGE NAME: **AddAccount.php**

*Page for adding employee accounts. Only accessible by admins*.

- Has form input fields for **Name**, **Email**, **Password**, and a radio button for account type.
- Regex validation is required for the email and password. Password must be at least 8 letters long, have 1 special character, 1 small character, 1 digit, and 1 capitalized character.
- Warning message appears at the bottom if invalid password strucutre is inputted.

PAGE NAME: **EditAccount.php**

*Page for adding employee accounts. Only accessible by admins*.

- The exact same layout, functions, and regex validation as **AddAccount.php**, but the default values for the form inputs are those of the account that's currently being edited.