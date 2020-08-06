# payroll-app
There you can manage payrolls in your company!

## How to create department?
```bash
docker-compose exec payroll-app bin/console payroll:create-department <name> <bonus type> <bonus value>
docker-compose exec payroll-app bin/console payroll:create-department "Human Resources" "yearly" 500
```
In the result should be UUID of newly created department.

## How to hire worker?
```bash
docker-compose exec payroll-app bin/console payroll:hire-worker "<first name>" "<last name>" "<department uuid" "<salary>"
docker-compose exec payroll-app bin/console payroll:hire-worker "Jon" "Snow" "91587124-1ed0-4550-af23-a7fe18acf2d3" "5000"
```
In the result should be UUID of a hired worker.
