import React from 'react';
import ReactDOM from 'react-dom';
import ContactForm from './components/ContactForm';
import registerServiceWorker from './registerServiceWorker';

ReactDOM.render(<ContactForm />, document.querySelector('.react-contact'));
registerServiceWorker();
