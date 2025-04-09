<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Filament Path
    |--------------------------------------------------------------------------
    |
    | Aqui você pode definir o caminho da URL que será usado para acessar o painel
    | de administração do Filament. O padrão é 'admin', mas você pode personalizar
    | para qualquer valor que desejar.
    |
    */

    'path' => 'tb3',  // Defina o valor para a rota que você deseja, por exemplo: 'painel'

    /*
    |--------------------------------------------------------------------------
    | Autenticação do Painel
    |--------------------------------------------------------------------------
    |
    | Aqui você pode configurar a autenticação do painel. Por padrão, o Filament usa
    | a autenticação do Laravel. Se você quiser usar outra lógica de autenticação,
    | você pode personalizar essas configurações.
    |
    */

    'auth' => [
        'guard' => 'web',  // O guard que será usado para proteger o painel
    ],

    /*
    |--------------------------------------------------------------------------
    | Outras configurações do Filament
    |--------------------------------------------------------------------------
    |
    | Você pode adicionar outras configurações que o Filament oferece. Aqui, você
    | pode definir temas, middlewares adicionais, e muito mais.
    |
    */

];
