# borcase
Araç zimmet ve kullanıcı yönetimi - Next.js(Frontend) ve Laravel(Backend)

# Project setup hosts file
127.0.0.1       api.borcase.com
127.0.0.1       borcase.com

# Project setup with docker

```bash

$ cd docker/
$ docker-compose -f docker-compose.yml -f docker-compose.dev.yml --project-name borcase --env-file ./config/.env up --build -d

```