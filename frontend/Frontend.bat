@ECHO OFF
CD password-manager/frontend
START http://localhost:8080
npm run serve --port=8080
PAUSE