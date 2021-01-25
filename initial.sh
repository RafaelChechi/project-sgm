docker rm -f project-sgm

docker build . --file "Dockerfile" --no-cache --tag project-sgm

docker run -d -p 80:80 --network local --name project-sgm project-sgm

docker ps
docker exec -it --user root project-sgm bash