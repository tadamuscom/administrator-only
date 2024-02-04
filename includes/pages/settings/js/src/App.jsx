import React from "react";
import { Header, resetForm, triggerError } from '@tadamus/wpui';
import SettingsForm from "./components/SettingsForm";

function App( props ) {
    const submit = ( e ) => {
        e.preventDefault();

        const btn = document.querySelector( '#' + e.target.id + ' input[type="submit"]' );
        btn.disabled = true;
        btn.value = 'Loading...';

        resetForm( e.target );

        const formData= new FormData( e.target );
        const frontEnd          = formData.get( 'admon-front-end' );
        const frontEndLink      = formData.get( 'admon-front-end-link' );
        const restApi           = formData.get( 'admon-rest-api' );
        const restApiLink       = formData.get( 'admon-rest-api-link' );
        const excludedPages     = formData.get( 'admon-excluded-pages' );
        const deleteAll         = formData.get( 'admon-delete-data' );

        let go = true;

        const status = document.getElementById( 'tada-status' );

        if( frontEnd ){
            if( frontEndLink.length < 1 ){
                triggerError( 'admon-front-end-link', 'The redirection link field cannot be empty' );

                go = false;
            }
        }

        if( restApi ){
            if( restApiLink.length < 1 ){
                triggerError( 'admon-rest-api-link', 'The redirection link field cannot be empty' );

                go = false;
            }
        }

        if( ! go ) {
            btn.value = 'Save Settings';
            btn.disabled = false;

            status.style.color = 'red';
            status.innerText = 'Please fix the errors above ❌';

            if( status.classList.contains( 'tada-hidden' ) ){
                status.classList.remove( 'tada-hidden' );
            }

            return;
        }

        wp.apiFetch( {
            path: '/tadamus/admon/v1/settings',
            method: 'POST',
            data:{
                nonce: admon_settings.nonce,
                front_end: frontEnd,
                front_end_link: frontEndLink,
                excluded_pages: excludedPages,
                rest_api: restApi,
                rest_api_link: restApiLink,
                delete_all: deleteAll
            }
        } ).then( ( result ) => {
            btn.value = 'Save Settings';
            btn.disabled = false;
            status.innerText = result.data.message;

            if( result.success ){
                status.style.color = 'green';
            }else{
                status.style.color = 'red';
                status.innerText = status.innerText + ' ❌'
            }

            if( status.classList.contains( 'tada-hidden' ) ){
                status.classList.remove( 'tada-hidden' );
            }
        } );
    }

    return (
        <div>
            <Header pageTitle='Administrator Only - Settings' logoLink={ admon_settings.logo } />
            <SettingsForm onSubmit={ submit } />
        </div>
    );
}

export default App;