import React, { Component } from "react";

class App extends Component {
  constructor(props) {
    super(props);
    this.state = {
      filteredEmoji: filterEmoji("", 20)
    };
  }
  render() {
    return (
      <div>Test</div>
    );
  }
}
export default App;
