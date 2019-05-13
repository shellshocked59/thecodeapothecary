import React, { Component } from "react";

class FormInputElement extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      loading: false,
      submitted: false
    };

    this.handleChange = this.handleChange.bind(this);
  }

  handleChange(event) {
    this.setState({value: event.target.value});
  }

  render() {
      //show form
      return (
        <label>
          {this.props.label}:
          <input type="text" name={this.props.name} value="" onChange={this.handleChange} />
        </label>
      );
  }
}

export default FormInputElement;


