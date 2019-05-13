import React, { Component } from "react";
import FormInputElement from './FormInputElement';
import FormTextElement from './FormTextElement';
import FormSubmitElement from './FormSubmitElement';

class ContactForm extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      loading: false,
      submitted: false
    };

    this.handleChange = this.handleChange.bind(this);
    this.handleSubmit = this.handleSubmit.bind(this);
  }

  handleSubmit(event) {
    //alert('A name was submitted: ' + this.state.value);
    let tmpState = this.state;
    tmpState.submitted = true;
    this.setState(tmpState);
    event.preventDefault();
  }

  handleChange(event) {
    this.setState({value: event.target.value});
  }

  render() {
    if(this.state.loading){
      //show loading gif
      return (
        <p>loading</p>
      );
    }
    if(this.state.submitted){
      //show success state
      return (
        <h3>Submitted</h3>
      );
    }else{
      //show form
      return (
        <form className="contact-form" onSubmit={this.handleSubmit}>
          <h3>Contact</h3>
          <FormInputElement label="Name" name="name" />
          <FormInputElement label="Email" name="email" />
          <FormInputElement label="Subject" name="subject" />
          <FormTextElement label="Message" name="message" />
          <FormSubmitElement label="Send" />
        </form>
      );
    }
  }
}

export default ContactForm;


