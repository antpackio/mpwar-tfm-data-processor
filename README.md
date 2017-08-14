# mpwar-tfm-data-processor

Recoge **Raw Documents** y los **parsea** para recuperar la informacion relevante, convirtiendolos en una 
primera version de un **Enriched Document**. A continuacion, este primer **Enriched Document** es pasado por diferentes 
**servicios de enriquecimient**o los cuales agregan informacion y valor extra al documento.

Finalmente, por una parte, estos documentos son guardados en base de datos. Por otro lado, se formatea el documento
de la manera adecuada para ser conusmida por el front end y se colocan en cola, donde esperan ser consumidos por el 
front end.

Installing dependencies
`composer install`
Running Tests
`./vendor/bin/phpunit`
Create Database
`./bin/console doctrine:schema-tool:create`
Process Queue
`./bin/console queue:process`
Install required roles
`ansible-galaxy install -r ansible/requirements.yml -p ansible/roles`
Deploy code
`ansible-playbook -i ansible/inventories/hosts --private-key {{private_key}} ansible/deploy-code.yml`
