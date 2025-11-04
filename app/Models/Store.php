<?php

namespace App\Models;

/**
 * Compatibility wrapper: allow code referencing App\Models\Store to work.
 * Extends CustomerStore which is the canonical store model in this project.
 */
class Store extends CustomerStore
{
    // intentionally empty
}

// Backwards-compatibility: if some code references the badly-namespaced
// `Apps\models\store` (lowercase), provide that class too.
namespace Apps\models;

class store extends \App\Models\CustomerStore
{
    // intentionally empty compatibility alias
}
