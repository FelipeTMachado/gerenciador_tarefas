sudo docker-compose down

sudo docker build -t gerenciador-img .  
#docker-compose build
sudo docker-compose up -d

echo "Espere alguns segundos para o mysql iniciar..."
sleep 10

firefox localhost:8084

sudo docker exec -it 
