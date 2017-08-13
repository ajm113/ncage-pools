import React from 'react';              // React framework for everything to work.
import ReactDOM from 'react-dom';       // ReactDOM for our nifty Virtual DOM goodness.
import { Navbar, Nav, NavItem, NavDropdown, MenuItem } from 'react-bootstrap';   // Get our Navbar componenent used by Bootstrap.

const navbarInstance = (
  <Navbar>
    <Navbar.Header>
      <Navbar.Brand>
        <a href="/">Cage Pool Supplies</a>
      </Navbar.Brand>
    </Navbar.Header>
    <Nav>
      <NavItem eventKey={1} href="/">Browse</NavItem>
    </Nav>
    <Nav pullRight>
      <NavItem eventKey={2} href="/support">Support</NavItem>
      <NavDropdown eventKey={2} title="My Account" id="basic-nav-dropdown">
        <MenuItem eventKey={3.1}>Login</MenuItem>
        <MenuItem eventKey={3.2}>Register</MenuItem>
      </NavDropdown>
      <NavItem eventKey={4} href="#">Cart</NavItem>
    </Nav>
  </Navbar>
);

ReactDOM.render(navbarInstance, document.getElementById('header'));
