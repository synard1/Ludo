# kopean

php artisan make:controller Setting\\CompanyController --model=Company --resource


php artisan make:model Company --migration


php artisan module:make-livewire <Component> <Module> --view= --force --inline --custom

php artisan module:make-livewire ReporterSelect Helpdesk --view= --force --inline --custom


php artisan make:model StatusHistory -mR

php artisan make:controller Apps\\SignaturePadController --model=SignaturePad --resource

/opt/alt/php81/usr/bin/php artisan module:make UserMedia

cp -Rf /home/ludomyi/public_html/node_modules/@shopify /home/ludomyi/dev.ludo.my.id/node_modules

cp -Rf /home/ludomyi/dev.ludo.my.id/node_modules/@shopify /home/ludomyi/public_html/node_modules

php artisan make:migration add_image_path_and_logo_url_to_companies_table --table=companies

/opt/alt/php81/usr/bin/php artisan module:make-seed seed_fake_ticket_posts Helpdesk
/opt/alt/php81/usr/bin/php artisan module:seed Helpdesk


/opt/alt/php81/usr/bin/php  artisan module:make-migration add_report_time_to_work_orders_table Helpdesk

/opt/alt/php81/usr/bin/php  artisan module:make-model ServiceManagement -mc Helpdesk

/opt/alt/php81/usr/bin/php  artisan module:make-model CategoryNotif -mc Notification