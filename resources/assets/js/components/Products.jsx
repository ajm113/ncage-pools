import React from 'react';
import { Grid, Row, Col, Image, FormGroup, FormControl, ControlLabel } from 'react-bootstrap';   // Used to fetch the components we are using for the product display.

export default class Products extends React.Component {

    constructor(props) {
        super(props);

        this.state = {
            searchString: ''
        };

        this.handleChange = this.handleChange.bind(this);
    }

    handleChange(e) {
        this.setState({searchString: e.target.value});
    }

    render() {

        var products = this.props.items,
            searchString = this.state.searchString.trim().toLowerCase();

        if(searchString.length > 0) {
            products = products.filter(function(l) {
                return l.name.toLowerCase().match( searchString );
            });
        }

        return (
            <Grid>
                <Row>
                    <Col sm={12} md={10} lg={10}>
                        <form>
                            <FormGroup controlId="formBasicText" validationState={null}>
                                <ControlLabel>Enter the Product You Wish To Find</ControlLabel>
                                <FormControl type="search" value={this.state.value} placeholder="Search Products..." onChange={this.handleChange} />
                            </FormGroup>
                        </form>
                    </Col>
                </Row>
                <Row>
                    { products.map(function(l, i) {
                        return (
                            <Col xs={6} md={3} lg={3} key={i}>
                                <h3>{l.name}</h3>
                                <Image src={l.image} alt={l.name} responsive />
                            </Col>
                        )
                    })}
                </Row>
            </Grid>
        );
    }
}
