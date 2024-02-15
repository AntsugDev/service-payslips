# Progetto Service PaySlips

## Linguaggi ed estenzioni

### Linguaggi base
- Laravel: 10.x
- PHP: 8.2 e superiori
- node:  18.0.0
- npm: 8.6.0

### Estenzioni

- Composer:
  - laravel/passport <pre>composer require laravel/passport</pre> oppure in alternativa installare <pre>composer require tymon/jwt-auth --ignore-platform-req=ext-sodium --with-all-dependencies</pre>(*)
  - per questo progetto viene installata anche la libreria di laravel per il db MongoDb, attraverso il comando <pre>composer require mongodb/laravel-mongodb</pre>. Questa libreria è utilizzabile a patto chè nella propria versione di php sia presente la <i>dll</i> o il <i>so</i> di <strong>php_mongodb</strong>(*)
- Npm:
  - Installare tutti i seguenti plugin:
    <pre>
    "dependencies": {
        "@fontsource/roboto": "^5.0.8",
        "@fontsource/roboto-slab": "^5.0.18",
        "@mdi/font": "^7.4.47",
        "@vitejs/plugin-vue": "^5.0.4",
        "axios": "^1.6.7",
        "laravel-vite-plugin": "^1.0.1",
        "moment": "^2.30.1",
        "sass": "^1.70.0",
        "vite": "^5.1.2",
        "vue": "^3.3.8",
        "vue-router": "^4.2.5",
        "vuetify": "^3.5.4",
        "vuex": "^4.1.0"
    }
    </pre>
    Per le versioni fare fede a quelle segnate.
    Il comando da lanciare è <pre>npm install #NOME PACKAGE#@#VERSIONE#</pre>
- installare la dll/so di mongodb nel proprio ambiente php
***
<i>(*) La libreria  tymon/jwt-auth   genera un jwt token per le chiamate api (per la generazione si veda come esempio il file <a href="app\Console\Commands\GenerateJwt.php">GenerateJwt.php</a>). Inoltre, se viene usata questa libreria, al termine dell'installazione deve essere lanciato questo comando. <pre>php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"</pre>; nel file api.php usare questo come middleware, come da esempio:
<pre>
Route::middleware('jwt.auth')->get('user', function(Request $request) {
    return auth()->user();
});
</pre>.
Inoltre, le api devono essere messe tutte al di sotto del middleware <i>jwt.auth</i>
</i>


## Configurazioni

1. AUTH:
- per usare la parte per la creazioni delle api, va aggiunto nel file <a href="config/auth.php">auth.php</a>, il seguente codice: 
<pre>'api' => [
  'driver' => 'passport',
  'provider' => 'users',
  ]
</pre>
- nel file <a href="app/Providers/AuthServiceProvider.php">AuthServiceProvider.php</a>, nella funzione boot, va aggiunto la parte per la gestione dell rotte da parte di Passport:
<pre>
$this->registerPolicies();
if (! $this->app->routesAreCached()) {
Passport::routes();
}
</pre>
- Inoltre sempre nel file del punto 2, vanno inseriti i vari provider di controllo della login/auth che verrano inseriti nel file <i>auth.php</i>. Un esempio: 
<pre>
 Auth::extend('operators', function ($app, $name, array $config) {
            return new OperatorsKeycloakGuard(Auth::createUserProvider($config['provider']), $app->request);
        });
</pre>
- Ci può essere il caso che serva definire un nuovo provider di accesso sempre nello stesso file

***

2. MONGO DB:
- andare nel file <a href=".env">.env</a> e aggiungere i dati relativi alla connessione a MongoDB 
- andare nel file <a href="config/database.php">database.php</a> ed aggiungere la sezione relativa al database MongoDb:
  - aggiungo sotto connections:
    <pre>
    'mongodb' => [
            'driver' => 'mongodb',
            'dsn' => env('MONGODB_URI'),
            'database' => env('MONGODB_DATABASE'),
        ],
    </pre>
    <i>Oppure</i>
    <pre>
        'mongodb' => [
            'driver' => 'mongodb',
            'host' => env('MONGODB_HOST'),
            'port' => env('MONGODB_PORT'),
            'username' => env('MONGODB_USERNAME'),
            'password' => env('MONGODB_PASSWORD'),
            'database' => env('MONGODB_DATABASE'),
        ],
    </pre>
   - nella parte di default, assegno mongodb come database di default
- vado nel file <a href="config/app.php">app.php</a> e aggiungo il provider MongoDb sotto providers

***

## Creazione Table,Model

I model che devono essere creati devono usare il comando
<pre>php artisan make:model #NOME#</pre>
Una volta aperto il model, la classe estesa "Model" non sarà più <strong>Illuminate\Database\Eloquent\Model</strong>,
ma questa deve essere cancellata e al suo posto deve essere inserita <strong>MongoDB\Laravel\Eloquent\Model;</strong>. Inoltre,
sempre in questo file, all'interno della classe, va definita la variabile <pre>protected $connection = "mongodb";</pre>, che definisce la connessione appunto al db MongoDb.

Non vengono create i file delle tabelle per la migrations.


