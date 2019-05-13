import React, { Component } from "react";

class FormSubmitElement extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
     
    };

  }

  render() {
      //show form
      return (
        <input type="submit" value={this.props.label} />
      );
  }
}

export default FormSubmitElement;


