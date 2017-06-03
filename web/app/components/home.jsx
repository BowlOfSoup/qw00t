import React from 'react';
import { connect } from 'react-redux';
import Quotes from './quotes/quotes.jsx';
import * as quotesActions from '../actions/quotesActions';

class Home extends React.Component{
  constructor(props){
    super(props);

    this.state = {
      quotes: []
    }
  }

  componentDidMount() {
    this.getQuotes();
  }

  getQuotes() {
    this.props.getQuotes();
  }

  render() {

    let quotes = this.props.quotes.data ? this.props.quotes.data : [];
    console.log(quotes);
    return(
      <div>
        <section className="container row home">
          <h1>Random quotes</h1>
          <div>
            <Quotes quotes={quotes} />
          </div>
        </section>
        <button onClick={this.getQuotes.bind(this)}>Get Quotes</button>
      </div>
    )
  }
}

// Maps state from store to props
const mapStateToProps = (state, ownProps) => {
  console.log(state, ownProps)
  return {
    // You can now say this.props.books
    quotes: state.quotes
  }
};

// Maps actions to props
const mapDispatchToProps = (dispatch) => {
  return {
    // You can now say this.props.createBook
    getQuotes: data => dispatch(quotesActions.getRandomQuotes(data))
  }
};

// Use connect to put them together
export default connect(mapStateToProps, mapDispatchToProps)(Home);
