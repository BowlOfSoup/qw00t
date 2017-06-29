import React from 'react';
import { connect } from 'react-redux';
import InputComponent from '../elements/inputComponent.jsx';
import * as registerActions from '../../actions/registerActions'

class Register extends React.Component{

    constructor(props){
      super(props);

      this.state = {
        userdata: {
          username: '',
          password: ''
        }
      }
    }

    login() {
      console.log(this.state)
      this.props.login(this.state);
    }


    onChange(event) {
      var field = event.target.name,
          value = event.target.value;

      this.state.userdata[field] = value;

      this.setState({
        userdata: this.state.userdata
      });

    }

    render() {

      return(
          <section className="login">
            <h1>Login</h1>
            <InputComponent
              name="username"
              onChange={this.onChange.bind(this)}
              label="Username"
              value={this.state.userdata.username}>
            </InputComponent>
            <InputComponent
              name="password"
              onChange={this.onChange.bind(this)}
              label="Password"
              value={this.state.userdata.password}
              type="password">
            </InputComponent>
            <button onClick={this.login.bind(this)}>Login</button>
        </section>
      )
   }
}

// Maps state from store to props
const mapStateToProps = (state, ownProps) => {
  return {
    // You can now say this.props.books
    userdata: state.userdata
  }
};

// Maps actions to props
const mapDispatchToProps = (dispatch) => {
  return {
    // You can now say this.props.createBook
    login: data => dispatch(registerActions.login(data))
  }
};

// Use connect to put them together
export default connect(mapStateToProps, mapDispatchToProps)(Register);
