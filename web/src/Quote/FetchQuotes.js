import React from 'react';

class FetchQuotes extends React.Component {
  constructor() {
    super();
    this.state = {quotes: []}
  }

  componentDidMount() {
    fetch('/api/quotes?random=1')
      .then(response => response.json())
      .then(({result: quotes}) => this.setState({quotes}))
  }

  render() {
    let quotes = this.state.quotes
    return (
      <div>
        {quotes.map(quote =>
          <div className="quote-wrapper" key={quote.id}>
            <div className="quote-context">{quote.context}</div>
            <div className="quote-content">{quote.quote}</div>
            <div className="quote-person">- {quote.person}</div>
          </div>
        )}
      </div>
    )
  }
}

module.exports = FetchQuotes;
