# CORB TEMPLATE MANAGER 

A database templates compiler for laravel 5

## Installation

* Install as laravel project dependency 
   
   `composer require corb/template-manager`
   
   
* Add service provider in providers array (config/app.php)

    `Corb\TemplateManager\TemplateManagerServiceProvider::class,`


* Publish vendor files
    
    `$ php artisan vendor:publish --tag=config`
    
This will create a config file named template-manager.php


## Configuration file
 
* models
   The model property is an array containing Model Namespaces to access table columns.
   
      `'models' => [
              App\User::class               
          ];
      `
      
      or
      
       `models => [
                    'App\User'
                ];
            `
            
    Why? If you want to implement a WYSIWYG edit maybe this option is useful.

      
* use_routes
    If you want to use package routes to get available table fields set to true (default).
    
    `'use_routes'      => true,`
    
* route
    Url of the route, default 'templates'
     
    `'route'           => 'templates',`
    
    Ex:
         `localhost:8000/templates'` //This url return  all the configured tables with its columns

* template_table
     Name of the database table to be used, default 'templates'.
     
     WARNING: This configuration is used to create database migration. If you have an older migration it will be useless, so maybe you want to delete the migrate (Need to improve this).
     
     
## Template table

* Create migration 
   
   `$ php artisan vendor:publish --tag=config`
   This command create a new database migration using configuration file. Remember previous warning!.
   
* Run migrate

    `$ php artisan migrate`
    
    And thats it, now store your templates.
    
## Usage

### Compiling a template

Add the TemplateManager class to your code

`use Corb\TemplateManager\TemplateManager;`

Create a new TemplateManager object

`$template = new TemplateManager;`

Compile a new template

`$compiled_template  = $template->parse('test_template', $template_data)`

Complete example:


##### Database template: test_template

    Hi <b>{{$user->name}}</b>.<br/>
    Thanks to use corb template manager, if you need help 
    <a href="{{$help_link}}">Click here</a>.


##### Test code: routes.php

    use Corb\TemplateManager\TemplateManager;
    
    Route::get('/', function () {
        $template   = new TemplateManager;
        $user       = new stdClass;
        $user->name = 'Foo';
        $help_link  = 'https://github.com/gabomarin/l5-template-manager';
        $data = [
            'user'      => $user,
            'help_link' => $date
        ];
        echo $template->parse('test_template', $data);
    });
    
    
##### Result

    Hi Foo.
    Thanks to use corb template manager, if you need help Click here.



### TemplateManager Methods

#####  getModels()
   - Get models found in config file
   - Return array
   
        [
            App\User::class,
            App\Product::class,
        ]
#####  getFields()
    - Get table columns from config models
    - Return array
        [
            "users": [
                "id",
                "name",
                "email",
            ],
            "products": [
                "id",
                "name",
                "category",
                "sku"
            ]
        ]
        
##### parse($slug, $data)
    - Parse a template
    - Params: 
        - $slug: template slug
        - $data: Array of data to be parsed in template
    -Return: A string of compiled template
    
   
   
   

 