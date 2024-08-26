sudo docker rm -f gerenciador
sudo docker build -t gerenciador_tarefas .  
sudo docker run -d --name gerenciador -p 8084:80 gerenciador_tarefas

firefox localhost:8084
