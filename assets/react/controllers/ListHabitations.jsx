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
      const response = await axios.get(`/get_habitant_for_habitat/${habitationId}`); // Replace with your API endpoint
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

  return (
    <div className="container mt-4">
      <h2>Habitation List</h2>
      <Table striped bordered hover responsive>
        <thead>
          <tr>
            <th>Address</th>
            <th>Number of People</th>
            <th>Average Age</th>
          </tr>
        </thead>
        <tbody>
          {habitats.map((habitation) => (
            <React.Fragment key={habitation.id}>
              <tr onClick={() => handleRowClick(habitation.id)}>
                <td>{habitation.Adresse}</td>
                <td>{habitation.NbHabitants}</td>
                <td>{habitation.AgeMoyen !== null ? habitation.AgeMoyen : 'No Data'}</td>
              </tr>
              {expandedRow === habitation.id && habitantData.length > 0 && (
                <tr>
                  <td colSpan="3">
                    {/* Display details of people living at the same address */}
                    <ul>
                      {habitantData.map((habitant) => (
                        <li key={habitant.id}>
                          {habitant.firstname} {habitant.lastname} - {habitant.age} years old
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

