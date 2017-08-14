import '../sass/app.scss';              // Our stylesheet.

import React from 'react';              // React framework for everything to work.
import ReactDOM from 'react-dom';       // ReactDOM for our nifty Virtual DOM goodness.

import './components/Header.jsx';       // Handle our menu dropdowns.

import Products from './components/Products.jsx';

let items = [
    {name: 'test product 1', image: 'https://yt3.ggpht.com/-V92UP8yaNyQ/AAAAAAAAAAI/AAAAAAAAAAA/zOYDMx8Qk3c/s900-c-k-no-mo-rj-c0xffffff/photo.jpg'},
    {name: 'test product 2', image: 'https://yt3.ggpht.com/-V92UP8yaNyQ/AAAAAAAAAAI/AAAAAAAAAAA/zOYDMx8Qk3c/s900-c-k-no-mo-rj-c0xffffff/photo.jpg'},
    {name: 'apple', image: 'https://yt3.ggpht.com/-V92UP8yaNyQ/AAAAAAAAAAI/AAAAAAAAAAA/zOYDMx8Qk3c/s900-c-k-no-mo-rj-c0xffffff/photo.jpg'},
    {name: 'banana', image: 'https://yt3.ggpht.com/-V92UP8yaNyQ/AAAAAAAAAAI/AAAAAAAAAAA/zOYDMx8Qk3c/s900-c-k-no-mo-rj-c0xffffff/photo.jpg'}
];

ReactDOM.render(
    <Products items={ items } />,
    document.getElementById('store-page')
);
