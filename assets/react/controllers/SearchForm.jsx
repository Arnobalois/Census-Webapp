import React, { useState, useEffect } from 'react';
import axios from 'axios';
import 'bootstrap/dist/css/bootstrap.min.css';
import Modal from 'react-bootstrap/Modal';
import Button from 'react-bootstrap/Button';

const YourComponent = () => {
    const [people, setPeople] = useState([]);
    const [searchTerm, setSearchTerm] = useState('');
    const [selectedPerson, setSelectedPerson] = useState(null);
    const [selectedPersonId, setSelectedPersonId] = useState(null);

    const [show, setShow] = useState(false);

    // Fetch data from your API
    const fetchData = async () => {
        try {
            axios.get('/api/list_habitants').then(
                messages => { console.log(messages.data); setPeople(messages.data); });
        } catch (error) {
            console.error('Error fetching data:', error);
        }
    };

    const handleClose = async (delete_item) => {
        setShow(false);
        if(delete_item){
            await axios.delete(`/api/delete_user/${selectedPersonId}`);
            fetchData();
        }
    }
    const handleShow = () => setShow(true);


    useEffect(() => {
        fetchData();
    }, []); // Empty dependency array ensures the effect runs only once when the component mounts
    const formatDate = (dob) => {
        const date = new Date(dob);
        const formattedDate = new Intl.DateTimeFormat('en-GB').format(date);
        return formattedDate;
    };
    const handleDelete = (personName,personId) => {
        // Open the delete confirmation dialog
        setSelectedPerson(personName);
        setSelectedPersonId(personId);
        handleShow();
    };
    const handleNew = () =>{
        window.location.href = `/Add_User`;
    }

    const handleModify = (personId) => {
        // Implement modify logic using your API
        // Make sure to handle errors appropriately
        
        window.location.href = `/Modify_User/${personId}`;
    };

    const filteredPeople = people.filter((person) =>
        `${person.Nom} ${person.Prenom}`.toLowerCase().includes(searchTerm.toLowerCase())
    );

    return (
        <div className="container mt-4">
            <div className="mb-3 d-flex justify-content-between align-items-center">
                <input
                    type="text"
                    placeholder="Chercher par Nom ou Prenom"
                    className="form-control mx-2"
                    onChange={(e) => setSearchTerm(e.target.value)}
                />
                <Button variant="primary" onClick={() => handleNew()}>Nouveau</Button>
            </div>


            <table className="table">
                <thead>
                    <tr>
                        <th >Nom de famille</th>
                        <th >Prénom</th>
                        <th >Date de Naissance</th>
                        <th >Adresse</th>
                        <th >Modifier</th>
                        <th >Supprimer</th>
                    </tr>
                </thead>
                <tbody>
                    {filteredPeople.map((person) => (
                        <tr key={person.id}>
                            <td >{person.Nom}</td>
                            <td >{person.Prenom}</td>
                            <td >{formatDate(person.DateDeNaissance.date)}</td>
                            <td >{person.Adresse}</td>
                            <td >
                                <Button variant="primary" onClick={() => handleModify(person.id)}>
                                    Modifier
                                </Button>
                            </td>
                            <td >
                                <Button variant="danger" onClick={() => handleDelete(person.Prenom,person.id)}>
                                    Supprimer
                                </Button>
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>

            <Modal show={show} onHide={handleClose}>
                <Modal.Header closeButton>
                    <Modal.Title>Attention !</Modal.Title>
                </Modal.Header>
                <Modal.Body>Étes-vous sûr de vouloir supprimer {selectedPerson}?</Modal.Body>
                <Modal.Footer>
                    <Button variant="secondary" onClick={() => handleClose(false)}>
                        Non
                    </Button>
                    <Button variant="danger" onClick={()=>handleClose(true)}>
                        Oui
                    </Button>
                </Modal.Footer>
            </Modal>

        </div>
    );
};

export default YourComponent;
