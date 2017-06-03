
import React from 'react';

class Quote extends React.Component{
  constructor(props){
    // Pass props back to parent
    super(props);
  }

  render() {
    // Title input tracker
    console.log(this.props)
    return(
      <div className="quote-wrapper" key={this.props.quote.id}>
        <div className="quote-context">{this.props.quote.context}</div>
        <div className="quote-content">{this.props.quote.quote}</div>
        <div className="quote-person">- {this.props.quote.person}</div>
      </div>
    )

  }

}

export default Quote;
