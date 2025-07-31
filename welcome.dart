import 'package:flutter/material.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Welcome Page',
      debugShowCheckedModeBanner: false,
      theme: ThemeData(
        primarySwatch: Colors.pink,
        visualDensity: VisualDensity.adaptivePlatformDensity,
      ),
      home: const WelcomePage(),
    );
  }
}

class WelcomePage extends StatelessWidget {
  const WelcomePage({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: Colors.black, // Background color of the whole screen
      body: Center(
        child: Container(
          width: 350, // A fixed width to mimic the image aspect ratio
          decoration: BoxDecoration(
            color: Colors.white,
            borderRadius: BorderRadius.circular(20), // Slightly rounded corners if desired
          ),
          child: Column(
            children: [
              // "page welcome" text at the top left
              Align(
                alignment: Alignment.topLeft,
                child: Padding(
                  padding: const EdgeInsets.only(top: 20.0, left: 20.0),
                  child: Text(
                    'page welcome',
                    style: TextStyle(
                      color: Colors.grey[700],
                      fontSize: 18,
                      fontWeight: FontWeight.w500,
                    ),
                  ),
                ),
              ),
              Expanded(
                child: Column(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    // Title Text
                    RichText(
                      textAlign: TextAlign.center,
                      text: const TextSpan(
                        style: TextStyle(
                          fontSize: 28,
                          fontWeight: FontWeight.bold,
                          color: Colors.black,
                        ),
                        children: <TextSpan>[
                          TextSpan(text: 'find your best\n'),
                          TextSpan(
                            text: 'companion',
                            style: TextStyle(color: Color(0xFFFCB5C6)), // Pink color
                          ),
                          TextSpan(text: ' with us'),
                        ],
                      ),
                    ),
                    const SizedBox(height: 30), // Space between text and images

                    // Images layout
                    Stack(
                      alignment: Alignment.center,
                      children: [
                        // Main person image
                        Positioned(
                          child: Image.asset(
                            'woman.png', // Replace with your image path
                            height: MediaQuery.of(context).size.height * 0.5, // Adjust size as needed
                            fit: BoxFit.contain,
                          ),
                        ),
                        // Top left cat
                        Positioned(
                          top: -MediaQuery.of(context).size.height * 0.1, // Adjust vertical position
                          left: MediaQuery.of(context).size.width * 0.05, // Adjust horizontal position
                          child: Image.asset(
                            'catsorange.png', // Replace with your image path
                            height: 80,
                            width: 80,
                            fit: BoxFit.contain,
                          ),
                        ),
                        // Top right cat
                        Positioned(
                          top: -MediaQuery.of(context).size.height * 0.1, // Adjust vertical position
                          right: MediaQuery.of(context).size.width * 0.05, // Adjust horizontal position
                          child: Image.asset(
                            'catsgrey .png', // Replace with your image path
                            height: 100,
                            width: 100,
                            fit: BoxFit.contain,
                          ),
                        ),
                        // Bottom right dog
                        Positioned(
                          bottom: -MediaQuery.of(context).size.height * 0.1, // Adjust vertical position
                          right: MediaQuery.of(context).size.width * 0.08, // Adjust horizontal position
                          child: Image.asset(
                            'dog.png', // Replace with your image path
                            height: 100,
                            width: 100,
                            fit: BoxFit.contain,
                          ),
                        ),
                      ],
                    ),
                    const SizedBox(height: 50), // Space between images and button

                    // Get Started Button
                    SizedBox(
                      width: 250, // Fixed width for the button
                      height: 60,
                      child: ElevatedButton(
                        onPressed: () {
                          // Handle button press
                          print('Get Started button pressed!');
                        },
                        style: ElevatedButton.styleFrom(
                          backgroundColor: const Color(0xFFFCB5C6), // Pink color
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(30), // Rounded corners
                          ),
                          elevation: 0, // No shadow
                        ),
                        child: const Text(
                          'Get Started',
                          style: TextStyle(
                            fontSize: 20,
                            fontWeight: FontWeight.bold,
                            color: Colors.white,
                          ),
                        ),
                      ),
                    ),
                  ],
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}