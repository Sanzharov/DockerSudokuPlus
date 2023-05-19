# Sudoku Plus

Installation
------------

Clone project
```bash
https://github.com/Sanzharov/DockerSudokuPlus.git
```
Usage

Build and start containers
```bash
docker-compose build
docker-compose up
```

Go to directory
```bash
cd src
```

Install composer packages
```bash
docker-compose exec fpm composer install
```

Get endpoint documentation
-----
```bash
http://localhost/api/doc
```

Tests
-----

### Unit tests

To run unit test just execute command:
```bash
docker-compose exec fpm vendor/bin/phpunit tests
```
