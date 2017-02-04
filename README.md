# AWS Cognito sample application
This sample application shows some basic functionality written against [AWS Cognito](https://aws.amazon.com/cognito). The following functionality is covered;

* User registration
* User login
* Accessing a secured page if logged in
* Resetting a forgotten password
* Logout

The application is written in PHP. I've tried to keep the code as simple as possible so that it can be used as an example for other languages as well. In addition, I have written a blog post where I explain how to [get started with AWS Cognito](https://sanderknape.com/2017/02/getting-started-with-aws-cognito). There you will find more theory and background about how to implement AWS Cognito.

The steps to get started are divided in two sections;

1. [Set up AWS Cognito with the correct configuration](#set-up-aws-cognito-with-the-correct-configuration)
2. [Configure and start the application](#configure-and-start-the-application)

## Set up AWS Cognito with the correct configuration
First we will set up a new AWS Cognito user pool with the correct configuration.

1. Visit your AWS console and go to the AWS Cognito service. Click on "Manage your User Pools" and click "Create a User Pool".
2. Specify a name for your pool and click "Review Defaults".
3. Optional: edit the password policy to remove some of the requirements. If you are just testing, using simple passwords will make it easier.
4. Click the "edit client" link. Specify a name for your app and be sure to *disable* the client secret and *enable* the ADMIN_NO_SRP_AUTH option.
5. Click "Create pool". Take note of the *Pool Id* at the top of the page and click on the apps page. Here, take note of the *App client id*.
6. Create a new file called `.env` next to the Dockerfile. Add the AWS region you are using, the pool ID and the client ID to this file. For the proper format, see below.
7. There are two methods for setting up the required AWS credentials for communicating with the AWS CLI:
  1. The recommended way is to spin up an EC2 instance with a role. You then assign the correct permissions to this role.
  2. If you want to spin up the application outside of AWS, you will need an AWS user. Create an AWS User and get the access token and secret key. Add these to the .env file (see below).
8. For testing, you can attach the `AmazonCognitoPowerUser` policy to either the created role or the user.

That should be it! The format is the .env file is as follows:

```
REGION=eu-west-1
CLIENT_ID=eu-west-1_abc123
USERPOOL_ID=abc123
AWS_ACCESS_KEY_ID=123 (Optional)
AWS_SECRET_ACCESS_KEY=abc (Optional)
```

## Configure and start the application
With the AWS Cognito user pool set up and the correct configuration added to the `.env` file, we can start the application.

1. [Install Docker](https://docs.docker.com/engine/installation/) and [Install Docker Compose](https://docs.docker.com/compose/install/). As mentioned, it is recommended to run the application on an EC2 instance so you don't need AWS access credentials.
2. Clone this repository: `git clone https://github.com/SanderKnape/aws-cognito-app.git`
3. Cd into the git repository and spin up the application with `docker-compose up -d`.
4. The application is now running on port 80. Check it out! You will be able to create a user (with your correct e-mailaddress to receive the token), confirm the signup, login, and more.
