<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ url('CSS/infopages/studentpermitinfostyle.css') }}">
    <title>Student Permit Guide</title>
    <style>
        /* Styles are included directly here */
       

    </style>
</head>
<body>
    <header>
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px;">
          <div>
            <h1>ImmigrationBW</h1>
          </div>
          <div style="display: flex; gap: 20px;">
            <a href="/" style="text-decoration: none; color: white;">Home</a>
            <a href="/workpermitinfo" style="text-decoration: none; color: white;">Work Permit Application</a>
            <a href="/register" style="text-decoration: none; color: white;">Register</a>
          </div>
          <div>
            <a href="/login" style="text-decoration: none; color: white;">Login</a>
          </div>
        </div>
      </header>
      
      
    <div class="container">
        <p>To study in Botswana as a non-citizen, you need a valid Student Permit. Follow the steps below to apply.</p>

        <div class="steps">
            <div class="step">
                <h2>Step 1: Register at an Institution</h2>
                <img src="assets/images/t1.jpg" alt="Register at Institution">  <!-- Image Placeholder -->
                <p>You must first complete your registration at a recognized educational institution in Botswana.</p>
            </div>

            <div class="step">
                <h2>Step 2: Determine Your Stay Duration</h2>
                <img src="assets/images/t2.jpg" alt="Determine Stay Duration"> <!-- Image Placeholder -->
                <p>
                    If staying for less than 6 months, apply for a waiver.<br>
                    If staying for more than 6 months, apply for a full student residence permit.
                </p>
            </div>

            <div class="step">
                <h2>Step 3: Gather Required Documents</h2>
                <img src="assets/images/t3.jpg" alt="Gather Required Documents"> <!-- Image Placeholder -->
                <ul>
                    Passport-sized photos<br>
                    Certified copy of your birth certificate<br>
                    Proof of immigration fee payment
                </ul>
            </div>

            <div class="step">
                <h2>Step 4: Submit Your Application</h2>
                <img src="assets/images/t4.jpg" alt="Submit Application"> <!-- Image Placeholder -->
                <p>Submit your completed application form to the designated immigration office.</p>
            </div>

            <div class="step">
                <h2>Step 5: Await Processing</h2>
                <img src="assets/images/t5.jpg" alt="Await Processing"> <!-- Image Placeholder -->
                <p>The immigration office will review your application and notify you when your permit is ready for collection.</p>
            </div>
        </div>


        <p class="note"><strong>Note:</strong> Ensure all documents are clear and correctly certified to avoid delays. Contact the Botswana Department of Immigration for assistance.</p>

        <div class="apply-button">
            <button onclick="window.location.href='/register'">Create Account and Apply</button>
        </div>

    </div>
    <footer>
        <p>Copyright © 2024 Botswana Immigration ServicesCompany. All rights reserved. 
    </footer>
</body>
</html>
