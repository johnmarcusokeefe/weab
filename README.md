# weab
Web Based Editor and Browser

Installation:

Drop the Edit folder or whatever you want to call into a folder under the root folder. 

Create .htpasswd and set the user password: $ sudo htpasswd -c /etc/.htpasswd user (note: -c creates a new file and
can be ommitted if an existing file is used)

Security:

Currently using .htaccess level security. As the utility allows potentially damaging changes to content it is important to test that the folder is fully secure before

Issues:

No version control

ToDo:

Add a .htaccess file check to ensure the installation is secure by default.

An install routine that prompts for requirements

Auto local storage saves to ensure integrity over patchy internet
