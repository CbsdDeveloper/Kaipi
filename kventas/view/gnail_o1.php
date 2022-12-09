<!DOCTYPE html>
<html>

<head>
    <script type="text/javascript">
    // Your Client ID can be retrieved from your project in the Google
    // Developer Console, https://console.developers.google.com
    // Also the URL has to be allowed or 401 errors will be thrown on the console
     var CLIENT_ID      = '616310257178-kvei6sogsii891qf7bd27vghloq7t0ca.apps.googleusercontent.com';
    var SCOPES = ["https://www.googleapis.com/auth/contacts.readonly"];
    /**
     * Check if current user has authorized this application.
     */
    function checkAuth() {
        gapi.auth.authorize({
            'client_id': CLIENT_ID,
            'scope': SCOPES.join(' '),
            'immediate': true
        }, handleAuthResult);
    }
    /**
     * Handle response from authorization server.
     *
     * @param {Object} authResult Authorization result.
     */
    function handleAuthResult(authResult) {
        var authorizeDiv = document.getElementById('authorize-div');
        if (authResult && !authResult.error) {
            // Hide auth UI, then load client library.
            authorizeDiv.style.display = 'none';
            loadPeopleApi();
        } else {
            // Show auth UI, allowing the user to initiate authorization by
            // clicking authorize button.
            authorizeDiv.style.display = 'inline';
        }
    }
    /**
     * Initiate auth flow in response to user clicking authorize button.
     *
     * @param {Event} event Button click event.
     */
    function handleAuthClick(event) {
        gapi.auth.authorize({
                client_id: CLIENT_ID,
                scope: SCOPES,
                immediate: false
            },
            handleAuthResult);
        return false;
    }
    /**
     * Load Google People client library. List names if available
     * of 10 connections.
     */
    function loadPeopleApi() {
        gapi.client.load('https://people.googleapis.com/$discovery/rest', 'v3', listConnectionNames);
    }
    /**
     * Print the display name if available for 10 connections.
     */
    function listConnectionNames() {
        var request = gapi.client.people.people.connections.list({
            'resourceName': 'people/me',
            // Includes the fields requested. No additional calls to the get endpoint are needed
            'requestMask.includeField': ['person.phoneNumbers', 'person.names','person.emailAddresses','person.genders'],
            'sortOrder' : 'FIRST_NAME_ASCENDING',
            // 500 is the maximum size
            'pageSize': 500,
        });
        request.execute(function(resp) {
            var connections = resp.connections;
            appendPre('Connections:');
            if (connections.length > 0) {
				
				
                for (i = 0; i < connections.length; i++) {
					
                    var person = connections[i];
					
                    if (person.names && person.names.length > 0) {
						
                        var text = '' + person.names[0].displayName;
						
                        if(person.phoneNumbers && person.phoneNumbers.length > 0) {
							
                          text +=  ' - ' + person.phoneNumbers[0].canonicalForm;
							
                        } else {
							
                          text += '-';
							
                        }
						
						if(person.emailAddresses) {
                          text +=  ' - '  + person.emailAddresses[0].value ;
                        } else {
                          text += '- ';
                        }
						
                        appendPre(text);
						
                    } else {
						
                        appendPre("-");
						
                    }
					
					
					
                }
				
            } else {
                appendPre('-');
            }
        });
    }
    /**
     * Append a pre element to the body containing the given message
     * as its text node.
     *
     * @param {string} message Text to be placed in pre element.
     */
    function appendPre(message) {
        var pre = document.getElementById('output');
        var textContent = document.createTextNode(message + '\n');
        pre.appendChild(textContent);
    }
    </script>
    <script src="https://apis.google.com/js/client.js?onload=checkAuth">
    </script>
</head>

<body>
    <div id="authorize-div" style="display: none">
        <span>Authorize access to People API</span>
        <!--Button for the user to click to initiate auth sequence -->
        <button id="authorize-button" onclick="handleAuthClick(event)">
            Authorize
        </button>
    </div>
    <pre id="output"></pre>
</body>

</html>