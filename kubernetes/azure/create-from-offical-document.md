# Create from Azure

This is just a simple version from official document,
but you can say it's almost the same.

## Create services

* Kubernetes Service and Resource Groups

## CLI - Check Kubernetes Service

open a terminal from `Kubernetes Service` -> `CLI / PS`

Check nodes by `kubectl get nodes`

and you'll see error:

`couldn't get current server API group list: the server has asked ....`

**Grant credentials**

Replace `test` and `k8s` with your own name and resource group name.

`az aks get-credentials --resource-group k8s --name test`

And check nodes again with

`kubectl get nodes`

## CLI - Deploy by .yml

create setting file `docker-compose-quickstart.yml`.

```yml
version: "3.7"
services:
  rabbitmq:
    image: rabbitmq:3.11.17-management-alpine
    container_name: 'rabbitmq'
    restart: always
    environment:
      - "RABBITMQ_DEFAULT_USER=username"
      - "RABBITMQ_DEFAULT_PASS=password"
    ports:
      - 15672:15672
      - 5672:5672
    healthcheck:
      test: ["CMD", "rabbitmqctl", "status"]
      interval: 30s
      timeout: 10s
      retries: 5
    volumes:
      - ./rabbitmq_enabled_plugins:/etc/rabbitmq/enabled_plugins
    networks:
      - backend_services
  orderservice:
    build: src/order-service
    container_name: 'orderservice'
    restart: always
    ports:
      - 3000:3000
    healthcheck:
      test: ["CMD", "wget", "-O", "/dev/null", "-q", "http://orderservice:3000/health"]
      interval: 30s
      timeout: 10s
      retries: 5
    environment:
      - ORDER_QUEUE_HOSTNAME=rabbitmq
      - ORDER_QUEUE_PORT=5672
      - ORDER_QUEUE_USERNAME=username
      - ORDER_QUEUE_PASSWORD=password
      - ORDER_QUEUE_NAME=orders
      - ORDER_QUEUE_RECONNECT_LIMIT=3
    networks:
      - backend_services
    depends_on:
      rabbitmq:
        condition: service_healthy
  productservice:
    build: src/product-service
    container_name: 'productservice'
    restart: always
    ports:
      - 3002:3002
    healthcheck:
      test: ["CMD", "wget", "-O", "/dev/null", "-q", "http://productservice:3002/health"]
      interval: 30s
      timeout: 10s
      retries: 5
    networks:
      - backend_services
  storefront:
    build: src/store-front
    container_name: 'storefront'
    restart: always
    ports:
      - 8080:8080
    healthcheck:
      test: ["CMD", "wget", "-O", "/dev/null", "-q", "http://storefront:80/health"]
      interval: 30s
      timeout: 10s
      retries: 5
    environment:
      - VUE_APP_PRODUCT_SERVICE_URL=http://productservice:3002/
      - VUE_APP_ORDER_SERVICE_URL=http://orderservice:3000/
    networks:
      - backend_services
    depends_on:
      - productservice
      - orderservice
networks:
  backend_services:
    driver: bridge
```


Deploy:

`kubectl apply -f aks-store-quickstart.yaml`


### CLI - Check result

`kubectl get service store-front --watch`

paste `EXTERNAL-IP` to browser.