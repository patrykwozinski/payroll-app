# payroll-app
There you can manage payrolls in your company!

## Installation
You need a `Docker` with `docker-compose`, bro! 👌
```bash
docker-compose build
docker-compose up -d
```

## How to create department?
```bash
docker-compose exec payroll-app bin/console payroll:create-department <name> <bonus type> <bonus value>
docker-compose exec payroll-app bin/console payroll:create-department "Human Resources" "yearly" 500
```
In the result should be UUID of newly created department.

## How to hire worker?
```bash
docker-compose exec payroll-app bin/console payroll:hire-worker <first name> <last name> <department uuid> <salary>
docker-compose exec payroll-app bin/console payroll:hire-worker "Jon" "Snow" "91587124-1ed0-4550-af23-a7fe18acf2d3" "5000"
```
In the result should be UUID of a hired worker.

## Static analysis
Following command is running: PHP CS Fixer, PHP Stan and deptrac.
```bash
docker-compose exec payroll-app composer quality:check
```

## Tests
You can run tests via:
```bash
docker-compose exec payroll-app composer tests:all
# OR
docker-compose exec payroll-app composer tests:unit
```
In the future I'd like to add more types of tests.