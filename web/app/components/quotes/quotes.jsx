import React from 'react';
import Quote from './quote/quote.jsx';

class Quotes extends React.Component{
  constructor(props){
    // Pass props back to parent
    super(props);
  }

  render() {
    // Title input tracker
    let quotes = this.props.quotes;
    console.log(quotes);
    return(
      <section className="container">
        {quotes.map(quote =>
          <Quote key={quote.id} quote={quote}/>
        )}
      </section>
    )

  }

}

export default Quotes;
