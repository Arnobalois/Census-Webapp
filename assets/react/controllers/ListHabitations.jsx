// HabitationList.js
import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Table, Accordion, Card, Button } from 'react-bootstrap';

const ListHabitations = () => {
  const [habitats, setHabitats] = useState([]);
  const [expandedRow, setExpandedRow] = useState(null);
  const [habitantData, setHabitantData] = useState([]);

  useEffect(() => {
    fetchData();
  }, []);

  const fetchData = async () => {
    try {
      const response = await axios.get('/api/list_habitations'); // Replace with your API endpoint
      setHabitats(response.data);
    } catch (error) {
      console.error('Error fetching habitations:', error);
    }
  };

  const fetchHabitantsForHabitat = async (habitationId) => {
    try {
      const response = await axios.get(`/api/habitants_at_habitat/${habitationId}`); // Replace with your API endpoint
      setHabitantData(response.data);
    } catch (error) {
      console.error('Error fetching habitants:', error);
    }
  };

  const handleRowClick = async (habitationId) => {
    if (expandedRow === habitationId) {
      setExpandedRow(null);
    } else {
      setExpandedRow(habitationId);
      await fetchHabitantsForHabitat(habitationId);
    }
  };

  const calculateAge = (dateOfBirth) => {
    const year = parseInt(dateOfBirth.substring(0, 4), 10);
    const month = parseInt(dateOfBirth.substring(4, 6), 10) - 1;
    const day = parseInt(dateOfBirth.substring(6, 8), 10);

    const dob = new Date(year, month, day);
    const currentDate = new Date();

    const age = currentDate.getFullYear() - dob.getFullYear();

    // Adjust age if the birthday hasn't occurred yet this year
    if (
      currentDate.getMonth() < dob.getMonth() ||
      (currentDate.getMonth() === dob.getMonth() && currentDate.getDate() < dob.getDate())
    ) {
      return age - 1;
    }

    return age;
  };

  return (
    <div className="container mt-4">
      <h2>Liste des Habitations</h2>
      <Table striped bordered hover responsive>
        <thead>
          <tr>
            <th>Adresse</th>
            <th>Nombre d'habitants</th>
            <th>Age moyen</th>
          </tr>
        </thead>
        <tbody>
          {habitats.map((habitation) => (
            <React.Fragment key={habitation.id}>
              <tr onClick={() => handleRowClick(habitation.id)}>
                <td>{habitation.Adresse}</td>
                <td>{habitation.NbHabitants}</td>
                <td>{habitation.AgeMoyen !== null ? calculateAge(habitation.AgeMoyen) : 'Pas de données'}</td>
              </tr>
              {expandedRow === habitation.id && habitantData.length > 0 && (
                <tr>
                  <td colSpan="3">
                    {/* Display details of people living at the same address */}
                    <ul className='d-flex flex-column bg-secondary'>
                      {habitantData.map((habitant) => (
                        <li key={habitant.id}>
                          {habitant.Prenom} {habitant.Nom} a {calculateAge(habitant.DateDeNaissance.date)} ans
                        </li>
                      ))}
                    </ul>
                  </td>
                </tr>
              )}
            </React.Fragment>
          ))}
        </tbody>
      </Table>
    </div>
  );
};

export default ListHabitations;

