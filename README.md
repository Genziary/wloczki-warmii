# Włóczki Warmii 🧶

## Table of contents 🪧

- [Description](#description-)
- [Software](#software-)
- [How to run the project](#how-to-run-the-project-%EF%B8%8F)
- [How to contribute](#how-to-contribute-)
- [Admin Panel](#admin-panel-)
- [Mail handling](#mail-handling-%EF%B8%8F)
- [Team members](#team-members-)

- [Using data scraper](scraper/README.md)
- [Running tests](tests/README.md)

## Description 📄

Project developed to replicate the features and design of [Włóczki Warmii](https://wloczkiwarmii.pl) website. It 
utilizes PrestaShop as the e-commerce backend, deployed with Docker for a streamlined setup.

> [!NOTE]
> This project was created for educational purposes only.

## Software 🧑‍💻

- PrestaShop 1.7.8
- MariaDB
- Docker
- Python
- MailDev

## How to run the project 🏃‍➡️

1. Clone the repository
```bash
git clone https://github.com/Genziary/wloczki-warmii.git
cd wloczki-warmii
```
2. Start the environment
```bash
docker compose up -d
```
3. Open http://localhost:8000 in web browser to start using the platform.

## How to contribute 🙌
After each main pull, use the following command to load newest database changes and update Docker images:
```bash
USE_DB_DUMP=1 docker compose up --build
```

After making changes to the database, generate an updated dump file using the following command:
```bash
docker exec wloczki-warmii-db-1 mysqldump -u wloczki-user --password=wloczki-password wloczki-warmii > shop/dump.sql
```

## Admin panel 👤

PrestaShop back office is located at `/admin-dev` (http://localhost:8000/admin-dev by default). \
Admin credentials:

|       Email        |       Password       |
|:------------------:|:--------------------:|
| admin@wloczki.pl   |      123123123       |

## Mail Handling ✉️

The project uses MailDev to handle email notifications during development. \
**Web interface** is accessible at http://localhost:1080, providing a clear preview of all sent emails for
testing purposes.

## Team members 🫂

- Kamil Wenta
- Gracjan Żukowski
- Martyna Koźbiał
- Anna Sztukowska
