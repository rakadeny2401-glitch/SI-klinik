<?php

use App\Providers\AppServiceProvider;
<<<<<<< HEAD

return [
    AppServiceProvider::class,
=======
use App\Providers\LegacyCodeProvider;

return [
    AppServiceProvider::class,
    LegacyCodeProvider::class,
>>>>>>> ac8524e09c4b6d8e79d9dab77789553ccb3097ea
];
