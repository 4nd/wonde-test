## Wonde Technical Test

### Get up and running
1. Create local '.env' configuration file  
   `cp .env.example .env`
2. Edit ports to ensure no conflicts for Web(80) and Mysql(3306) and enter WONDE_TOKEN and WONDE_SCHOOL_ID  
   `vi .env`
3. Bring up docker containers  
   `./bin/wonde up`
4. Install composer packages  
   `./bin/wonde composer install`
5. Create unique encryption key  
   `./bin/wonde artisan key:generate` 
6. Migrate database  
   `./bin/wonde artisan migrate`
7. Compile assets   
   `./bin/wonde npm install`  
   `./bin/wonde npm run build`
8. Synchronise data from Wonde API  
   `./bin/wonde artisan app:sync`
9. Browse to site
   `http://127.0.0.1:80` or whichever port specified in `.env`
10. Review other commands in `wonde` command  
   `./bin/wonde`

### Rationale
Given there are no current (within the next week or two) lessons allocated to employees, possibly due to summer holidays,
the application synchronises data from when there were active classes, so the 3 weeks starting 2023-07-01.

Browsing the application allows selection of Employee then Date to see the list of students for that day.

Enjoy!
