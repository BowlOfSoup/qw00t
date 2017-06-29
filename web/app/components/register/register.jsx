import React from 'react';
import { connect } from 'react-redux';
import InputComponent from '../elements/inputComponent.jsx';
import * as registerActions from '../../actions/registerActions'

class Register extends React.Component{

    constructor(props){
      super(props);

      this.state = {
        userdata: {
          name: '',
          username: '',
          password: '',
          email: ''
        }
      }
    }

    register() {
      this.props.register(this.state);
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
      console.log(this.props.userdata, this.props, this.state);
      return(
          <section className="register">
            <h1>Register</h1>
            <InputComponent
                name="name"
                onChange={this.onChange.bind(this)}
                label="Name"
                value={this.state.userdata.name}>
            </InputComponent>
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
            <InputComponent
              name="email"
              onChange={this.onChange.bind(this)}
              label="Email"
              value={this.state.userdata.email}>
            </InputComponent>
            <button onClick={this.register.bind(this)}>Register</button>
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
    register: data => dispatch(registerActions.register(data))
  }
};

// Use connect to put them together
export default connect(mapStateToProps, mapDispatchToProps)(Register);
