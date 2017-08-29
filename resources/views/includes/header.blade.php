<?php
    $query = (!isset($query)) ? '' : $query;
?>
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <a class="navbar-brand" href="/">CAGE POOL SUPPLIES</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item {{ (Request::is('/')) ? 'active' : '' }}">
            <a class="nav-link" href="/">Home</a>
          </li>
          <li class="nav-item {{ (Request::is('about')) ? 'active' : '' }}">
            <a class="nav-link" href="/about">About</a>
          </li>
          <li class="nav-item {{ (Request::is('support')) ? 'active' : '' }}">
            <a class="nav-link" href="/support">Support</a>
          </li>
        </ul>
        <form class="form-inline my-2 my-lg-0 search-form">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" required="required" minlength="3" value="{{ $query }}">
            <button class="btn btn-success my-2 my-sm-0" type="submit">
                <i class="fa fa-search"></i>
                Search
            </button>
        </form>
        <ul class="navbar-nav nav-fill">
          <li class="nav-item {{ (Request::is('cart')) ? 'active' : '' }}">
            <a class="nav-link" href="/cart">My Cart (<span class="current-cart-count">{{ Cart::count() }}</span>)</a>
          </li>
        </ul>
    </div>
</nav>
