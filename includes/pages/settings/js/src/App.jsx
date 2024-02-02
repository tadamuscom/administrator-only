import React from "react";
import { Header, HeadingTwo, resetForm, triggerError } from '@tadamus/wpui';
import SettingsForm from "./components/SettingsForm";

function App( props ) {
    const submit = ( e ) => {
        e.preventDefault();

        const btn = document.querySelector( '#' + e.target.id + ' input[type="submit"]' );
        btn.disabled = true;
        btn.value = 'Loading...';

        resetForm( e.target );

        const formData = new FormData( e.target );

        let go = true;

        const status = document.getElementById( 'tada-status' );

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