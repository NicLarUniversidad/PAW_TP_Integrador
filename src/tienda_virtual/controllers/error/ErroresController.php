<?php

namespace src\tienda_virtual\controllers\error;

class ProjectController
{
    /**
     * Show the Error 404 page.
     */
    public function notFound()
    {
        return view('not-found');
    }

    /**
     * Show the Error 500 page.
     */
    public function internalError()
    {
        return view('server-error');
    }
}
