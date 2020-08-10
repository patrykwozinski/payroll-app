# payroll-app
There you can manage payrolls in your company!


## Technical part
### Installation
You need a `Docker` with `docker-compose`, bro! 👌
```bash
docker-compose build
docker-compose up -d
docker-compose exec payroll-app composer database:setup
```

### Static analysis
Following command is running: PHP CS Fixer, PHP Stan and deptrac.
```bash
docker-compose exec payroll-app composer quality:check
```

### Tests
You can run tests via:
```bash
docker-compose exec payroll-app composer tests:all
# OR
docker-compose exec payroll-app composer tests:unit
docker-compose exec payroll-app composer tests:integration
docker-compose exec payroll-app composer tests:functional
```
In the future 


## Business part
### How to create department?
```bash
docker-compose exec payroll-app bin/console payroll:create-department <name> <bonus type> <bonus value>
docker-compose exec payroll-app bin/console payroll:create-department "Human Resources" "yearly" 500
```
In the result should be UUID of newly created department.

### How to hire worker?
```bash
docker-compose exec payroll-app bin/console payroll:hire-worker <first name> <last name> <department uuid> <salary>
docker-compose exec payroll-app bin/console payroll:hire-worker "Jon" "Snow" "91587124-1ed0-4550-af23-a7fe18acf2d3" "5000"
```
In the result should be UUID of a hired worker.
I'd like to add more types of tests.

### How to generate a payroll?
```bash
docker-compose exec payroll-app bin/console payroll:generate <date>
docker-compose exec payroll-app bin/console payroll:generate "2021-01-01"
```

### How to show a payroll?
```bash
docker-compose exec payroll-app bin/console payroll:show <uuid> <OPTION --sort-field> <OPTION --sort-direction> <OPTION --filter-field> <OPTION --filter-value>
docker-compose exec payroll-app bin/console payroll:show 0e43d135-8bad-48d1-9e72-b6025d1c6774 --sort-field=total_salary --sort-direction=asc --filter-field=department_name --filter-value="Human Resources"
```
