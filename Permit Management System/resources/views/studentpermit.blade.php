<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Immigration Form</title>
    <link rel="stylesheet" href="{{ url('CSS/studentpermitstyle.css') }}">
</head>
<body>
    <div class="form-container">
        <h1>Immigration Application Form</h1>
        <h2>Welcome, {{ auth()->user()->name }}</h2>
        <form action="{{ route('submit-permit') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="step step-1 active">

                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" placeholder="Enter your phone number">
                @if ($errors->has('phone'))
        <div class="error">{{ $errors->first('phone') }}</div>
    @endif

                <label for="dob">Date of Birth <span class="required">*</span></label>
                <input type="date" id="dob" name="dob" required value="{{ old('dob') }}">
                @if ($errors->has('dob'))
        <div class="error">{{ $errors->first('dob') }}</div>
    @endif

               <label for="nationality">Nationality <span class="required">*</span></label>
<select id="nationality" name="nationality" required>
    <option value="">-- Select your nationality --</option>
    <option value="Afghanistan">Afghanistan</option>
    <option value="Albania">Albania</option>
    <option value="Algeria">Algeria</option>
    <option value="Andorra">Andorra</option>
    <option value="Angola">Angola</option>
    <option value="Antigua and Barbuda">Antigua and Barbuda</option>
    <option value="Argentina">Argentina</option>
    <option value="Armenia">Armenia</option>
    <option value="Australia">Australia</option>
    <option value="Austria">Austria</option>
    <option value="Azerbaijan">Azerbaijan</option>
    <option value="Bahamas">Bahamas</option>
    <option value="Bahrain">Bahrain</option>
    <option value="Bangladesh">Bangladesh</option>
    <option value="Barbados">Barbados</option>
    <option value="Belarus">Belarus</option>
    <option value="Belgium">Belgium</option>
    <option value="Belize">Belize</option>
    <option value="Benin">Benin</option>
    <option value="Bhutan">Bhutan</option>
    <option value="Bolivia">Bolivia</option>
    <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
    <option value="Botswana">Botswana</option>
    <option value="Brazil">Brazil</option>
    <option value="Brunei">Brunei</option>
    <option value="Bulgaria">Bulgaria</option>
    <option value="Burkina Faso">Burkina Faso</option>
    <option value="Burundi">Burundi</option>
    <option value="Cabo Verde">Cabo Verde</option>
    <option value="Cambodia">Cambodia</option>
    <option value="Cameroon">Cameroon</option>
    <option value="Canada">Canada</option>
    <option value="Central African Republic">Central African Republic</option>
    <option value="Chad">Chad</option>
    <option value="Chile">Chile</option>
    <option value="China">China</option>
    <option value="Colombia">Colombia</option>
    <option value="Comoros">Comoros</option>
    <option value="Congo (Brazzaville)">Congo (Brazzaville)</option>
    <option value="Congo (Kinshasa)">Congo (Kinshasa)</option>
    <option value="Costa Rica">Costa Rica</option>
    <option value="Croatia">Croatia</option>
    <option value="Cuba">Cuba</option>
    <option value="Cyprus">Cyprus</option>
    <option value="Czech Republic">Czech Republic</option>
    <option value="Denmark">Denmark</option>
    <option value="Djibouti">Djibouti</option>
    <option value="Dominica">Dominica</option>
    <option value="Dominican Republic">Dominican Republic</option>
    <option value="Ecuador">Ecuador</option>
    <option value="Egypt">Egypt</option>
    <option value="El Salvador">El Salvador</option>
    <option value="Equatorial Guinea">Equatorial Guinea</option>
    <option value="Eritrea">Eritrea</option>
    <option value="Estonia">Estonia</option>
    <option value="Eswatini">Eswatini</option>
    <option value="Ethiopia">Ethiopia</option>
    <option value="Fiji">Fiji</option>
    <option value="Finland">Finland</option>
    <option value="France">France</option>
    <option value="Gabon">Gabon</option>
    <option value="Gambia">Gambia</option>
    <option value="Georgia">Georgia</option>
    <option value="Germany">Germany</option>
    <option value="Ghana">Ghana</option>
    <option value="Greece">Greece</option>
    <option value="Grenada">Grenada</option>
    <option value="Guatemala">Guatemala</option>
    <option value="Guinea">Guinea</option>
    <option value="Guinea-Bissau">Guinea-Bissau</option>
    <option value="Guyana">Guyana</option>
    <option value="Haiti">Haiti</option>
    <option value="Honduras">Honduras</option>
    <option value="Hungary">Hungary</option>
    <option value="Iceland">Iceland</option>
    <option value="India">India</option>
    <option value="Indonesia">Indonesia</option>
    <option value="Iran">Iran</option>
    <option value="Iraq">Iraq</option>
    <option value="Ireland">Ireland</option>
    <option value="Israel">Israel</option>
    <option value="Italy">Italy</option>
    <option value="Jamaica">Jamaica</option>
    <option value="Japan">Japan</option>
    <option value="Jordan">Jordan</option>
    <option value="Kazakhstan">Kazakhstan</option>
    <option value="Kenya">Kenya</option>
    <option value="Kiribati">Kiribati</option>
    <option value="Kuwait">Kuwait</option>
    <option value="Kyrgyzstan">Kyrgyzstan</option>
    <option value="Laos">Laos</option>
    <option value="Latvia">Latvia</option>
    <option value="Lebanon">Lebanon</option>
    <option value="Lesotho">Lesotho</option>
    <option value="Liberia">Liberia</option>
    <option value="Libya">Libya</option>
    <option value="Liechtenstein">Liechtenstein</option>
    <option value="Lithuania">Lithuania</option>
    <option value="Luxembourg">Luxembourg</option>
    <option value="Madagascar">Madagascar</option>
    <option value="Malawi">Malawi</option>
    <option value="Malaysia">Malaysia</option>
    <option value="Maldives">Maldives</option>
    <option value="Mali">Mali</option>
    <option value="Malta">Malta</option>
    <option value="Marshall Islands">Marshall Islands</option>
    <option value="Mauritania">Mauritania</option>
    <option value="Mauritius">Mauritius</option>
    <option value="Mexico">Mexico</option>
    <option value="Micronesia">Micronesia</option>
    <option value="Moldova">Moldova</option>
    <option value="Monaco">Monaco</option>
    <option value="Mongolia">Mongolia</option>
    <option value="Montenegro">Montenegro</option>
    <option value="Morocco">Morocco</option>
    <option value="Mozambique">Mozambique</option>
    <option value="Myanmar">Myanmar</option>
    <option value="Namibia">Namibia</option>
    <option value="Nauru">Nauru</option>
    <option value="Nepal">Nepal</option>
    <option value="Netherlands">Netherlands</option>
    <option value="New Zealand">New Zealand</option>
    <option value="Nicaragua">Nicaragua</option>
    <option value="Niger">Niger</option>
    <option value="Nigeria">Nigeria</option>
    <option value="North Korea">North Korea</option>
    <option value="North Macedonia">North Macedonia</option>
    <option value="Norway">Norway</option>
    <option value="Oman">Oman</option>
    <option value="Pakistan">Pakistan</option>
    <option value="Palau">Palau</option>
    <option value="Palestine">Palestine</option>
    <option value="Panama">Panama</option>
    <option value="Papua New Guinea">Papua New Guinea</option>
    <option value="Paraguay">Paraguay</option>
    <option value="Peru">Peru</option>
    <option value="Philippines">Philippines</option>
    <option value="Poland">Poland</option>
    <option value="Portugal">Portugal</option>
    <option value="Qatar">Qatar</option>
    <option value="Romania">Romania</option>
    <option value="Russia">Russia</option>
    <option value="Rwanda">Rwanda</option>
    <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
    <option value="Saint Lucia">Saint Lucia</option>
    <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>
    <option value="Samoa">Samoa</option>
    <option value="San Marino">San Marino</option>
    <option value="Sao Tome and Principe">Sao Tome and Principe</option>
    <option value="Saudi Arabia">Saudi Arabia</option>
    <option value="Senegal">Senegal</option>
    <option value="Serbia">Serbia</option>
    <option value="Seychelles">Seychelles</option>
    <option value="Sierra Leone">Sierra Leone</option>
    <option value="Singapore">Singapore</option>
    <option value="Slovakia">Slovakia</option>
    <option value="Slovenia">Slovenia</option>
    <option value="Solomon Islands">Solomon Islands</option>
    <option value="Somalia">Somalia</option>
    <option value="South Africa">South Africa</option>
    <option value="South Korea">South Korea</option>
    <option value="South Sudan">South Sudan</option>
    <option value="Spain">Spain</option>
    <option value="Sri Lanka">Sri Lanka</option>
    <option value="Sudan">Sudan</option>
    <option value="Suriname">Suriname</option>
    <option value="Sweden">Sweden</option>
    <option value="Switzerland">Switzerland</option>
    <option value="Syria">Syria</option>
    <option value="Taiwan">Taiwan</option>
    <option value="Tajikistan">Tajikistan</option>
    <option value="Tanzania">Tanzania</option>
    <option value="Thailand">Thailand</option>
    <option value="Timor-Leste">Timor-Leste</option>
    <option value="Togo">Togo</option>
    <option value="Tonga">Tonga</option>
    <option value="Trinidad and Tobago">Trinidad and Tobago</option>
    <option value="Tunisia">Tunisia</option>
    <option value="Turkey">Turkey</option>
    <option value="Turkmenistan">Turkmenistan</option>
    <option value="Tuvalu">Tuvalu</option>
    <option value="Uganda">Uganda</option>
    <option value="Ukraine">Ukraine</option>
    <option value="United Arab Emirates">United Arab Emirates</option>
    <option value="United Kingdom">United Kingdom</option>
    <option value="United States">United States</option>
    <option value="Uruguay">Uruguay</option>
    <option value="Uzbekistan">Uzbekistan</option>
    <option value="Vanuatu">Vanuatu</option>
    <option value="Vatican City">Vatican City</option>
    <option value="Venezuela">Venezuela</option>
    <option value="Vietnam">Vietnam</option>
    <option value="Yemen">Yemen</option>
    <option value="Zambia">Zambia</option>
    <option value="Zimbabwe">Zimbabwe</option>
</select>
@if ($errors->has('nationality'))
        <div class="error">{{ $errors->first('nationality') }}</div>
    @endif

                <label for="id_number">Passport Number <span class="required">*</span></label>
                <input type="text" id="id_number" name="id_number" required placeholder="Please enter your passport number">

                <label for="course">Course of Study <span class="required">*</span></label>
                <input type="text" id="course" name="course" required placeholder="Please enter the course you are studying">
                @if ($errors->has('course'))
        <div class="error">{{ $errors->first('course') }}</div>
    @endif

                <label for="institution">Institution Name <span class="required">*</span></label>
<select id="institution" name="institution" required>
  <option value="" disabled selected>Select your institution</option>
  <option value="University of Botswana">University of Botswana</option>
  <option value="Botswana International University of Science and Technology">Botswana International University of Science and Technology</option>
  <option value="Botswana University of Agriculture and Natural Resources">Botswana University of Agriculture and Natural Resources</option>
  <option value="Botho University">Botho University</option>
  <option value="Limkokwing University of Creative Technology">Limkokwing University of Creative Technology</option>
  <option value="ABM University College">ABM University College</option>
  <option value="Botswana Accountancy College">Botswana Accountancy College</option>
  <option value="Gaborone University College of Law and Professional Studies">Gaborone University College of Law and Professional Studies</option>
  <option value="BA ISAGO University">BA ISAGO University</option>
  <option value="New Era College of Arts, Science and Technology">New Era College of Arts, Science and Technology</option>
  <option value="Imperial School of Business and Science">Imperial School of Business and Science</option>
  <option value="Boitekanelo College">Boitekanelo College</option>
</select>
@if ($errors->has('institution'))
        <div class="error">{{ $errors->first('institution') }}</div>
    @endif

                <label for="current_address">Current Place of Residence <span class="required">*</span></label>
                <input type="text" id="current_address" name="current_address" required placeholder="Please enter your current place of residence">
                @if ($errors->has('current_address'))
                <div class="error">{{ $errors->first('current_address') }}</div>
            @endif

                <label for="duration">Duration of Stay(months)<span class="required">*</span></label>
                <input type="text" id="duration" name="duration" required placeholder="Please enter the duration of your stay">
                @if ($errors->has('duration'))
        <div class="error">{{ $errors->first('duration') }}</div>
    @endif

                <button type="button" class="next-btn">Next</button>
            </div>

            <div class="step step-2">
                <h2>Submit Documents</h2>

                <!-- Admission Letter -->
                <div class="file-upload">
                    <label for="app_letter">Admission Letter <span class="required">*</span></label>
                    <label class="custom-file-upload">
                        <input type="file" id="app_letter" name="app_letter" required>
                        Choose File
                    </label>
                    <span id="app_letter_name">No file chosen</span>
                    @if ($errors->has('app_letter'))
                        <div class="error">{{ $errors->first('app_letter') }}</div>
                    @endif
                </div>

                <!-- Passport Photo -->
                <div class="file-upload">
                    <label for="passport_photo">Upload Passport Sized Photo (White background) <span class="required">*</span></label>
                    <label class="custom-file-upload">
                        <input type="file" id="passport_photo" name="passport_photo" required>
                        Choose File
                    </label>
                    <span id="passport_photo_name">No file chosen</span>
                    @if ($errors->has('passport_photo'))
                        <div class="error">{{ $errors->first('passport_photo') }}</div>
                    @endif
                </div>

                <!-- Birth Certificate -->
                <div class="file-upload">
                    <label for="birth_certificate">Birth Certificate <span class="required">*</span></label>
                    <label class="custom-file-upload">
                        <input type="file" id="birth_certificate" name="birth_certificate" required>
                        Choose File
                    </label>
                    <span id="birth_certificate_name">No file chosen</span>
                    @if ($errors->has('birth_certificate'))
                        <div class="error">{{ $errors->first('birth_certificate') }}</div>
                    @endif
                </div>

                <div id="background-check-result" style="display: none;">
                    <p id="background-result-message"></p>
                </div>

                <div id="face-recognition-section" style="display: none;">
                    <button type="button" onclick="startFaceRecognition()">Start Face Recognition</button>
                    <p id="face-recognition-status"></p>
                </div>

                <button type="button" class="prev-btn">Previous</button>
                
                    <form action="/checkout" method="POST">
                        @csrf
                        <button type="submit" class="submit-btn">Proceed to Payment</button>
                    </form>
               
            </div>
        </form>
    </div>

    <script src="{{ url('JS/studentpermit.js') }}"></script>
    <script>
        let uploadedImage = null;

        // Handle passport photo upload and background check
        document.getElementById('passport_photo').addEventListener('change', function (e) {
            uploadedImage = e.target.files[0];
            const formData = new FormData();
            formData.append('image', uploadedImage);

            fetch("{{ url('/check-background') }}", {
                method: "POST",
                body: formData,
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                }
            })
            .then(response => response.json())
            .then(data => {
                const resultMessage = document.getElementById('background-result-message');
                const resultBox = document.getElementById('background-check-result');

                if (data.message.includes('white background')) {
                    resultMessage.innerText = '✅ Passport photo is valid!';
                    resultMessage.style.color = 'green';
                } else {
                    resultMessage.innerText = '❌ Invalid background. Please use a white background.';
                    resultMessage.style.color = 'red';
                }

                resultBox.style.display = 'block';
                document.getElementById('face-recognition-section').style.display = 'block';
            })
            .catch(error => {
                console.error('Background check error:', error);
                alert('Error during background check.');
            });
        });

        // Start face recognition
        function startFaceRecognition() {
            if (!uploadedImage) {
                document.getElementById('face-recognition-status').innerText = '❌ No image uploaded.';
                return;
            }

            document.getElementById('face-recognition-status').innerText = 'Launching camera for face recognition...';

            const formData = new FormData();
            formData.append('image', uploadedImage);

            fetch('http://127.0.0.1:5001/start-camera', {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(res => {
                // When the popup appears and is closed, we'll consider it a success
                document.getElementById('face-recognition-status').innerText = '';
            })
            .catch(error => {
                // When the popup appears and is closed, we'll consider it a success
                document.getElementById('face-recognition-status').innerText = '';
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('face-recognition-status').innerText = '';
            });;
        }

        // Handle file name display for all file inputs
        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.addEventListener('change', function() {
                const fileName = this.files[0]?.name || 'No file chosen';
                const fileNameSpan = document.getElementById(this.id + '_name');
                if (fileNameSpan) {
                    fileNameSpan.textContent = fileName;
                }
            });
        });
    </script>
</body>
</html>
