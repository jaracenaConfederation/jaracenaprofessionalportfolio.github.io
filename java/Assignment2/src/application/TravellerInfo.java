package application;

import java.io.File;
import java.io.FileNotFoundException;
import java.io.PrintWriter;
import java.util.Scanner;

import javax.swing.JOptionPane;

import javafx.application.Application;
import javafx.event.ActionEvent;
import javafx.event.EventHandler;
import javafx.scene.Scene;
import javafx.scene.control.Alert;
import javafx.scene.control.Alert.AlertType;
import javafx.scene.control.Button;
import javafx.scene.control.ComboBox;
import javafx.scene.control.Label;
import javafx.scene.control.TextField;
import javafx.scene.layout.GridPane;
import javafx.scene.layout.HBox;
import javafx.scene.layout.VBox;
import javafx.stage.Stage;

public class TravellerInfo extends Application {

	public void start(Stage stage) {

		// Create labels
		Label lbTravelerName = new Label("Traveler Name: ");
		Label lbCytyFrom = new Label("City from: ");
		Label lbEmailId = new Label("Email: ");
		Label lbMobileNo = new Label("Mobile No: ");
		Label lbOcupation = new Label("Occupation: ");

		// Create Inputs (Textfuelds and comboboxs)
		TextField txfTravelerName = new TextField();
		ComboBox<String> cbxCityFrom = new ComboBox<>();
		cbxCityFrom.getItems().addAll("Toronto", "Thunder Bay", "Ottawa", "Vancouver", "Adelaide");
		TextField txfEmailId = new TextField();
		TextField txfMobileNo = new TextField();
		ComboBox<String> cbxOccupation = new ComboBox<>();
		cbxOccupation.getItems().addAll("Doctor", "Engineer", "Teacher", "Architect");

		// Create Buttons

		Button btnClose = new Button("Close");

		EventHandler<ActionEvent> eventClose = new EventHandler<ActionEvent>() { // Event for save button
			public void handle(ActionEvent e) {
				// TODO Auto-generated method stub
				System.exit(0);
			}

		};

		// Event search control
		btnClose.setOnAction(eventClose);

		Button btnSearch = new Button("Search...");
		EventHandler<ActionEvent> eventSearch = new EventHandler<ActionEvent>() { // Event for save button
			public void handle(ActionEvent e) {

				File file = new File("TravellerInfo.txt");
				Boolean exist = false;
				int index = 1;

				String Name = null;
				String Email = null;
				String Occupation = null;
				String City = null;
				String Mobile = txfMobileNo.getText();

				try {

					Scanner inScanner = new Scanner(file);

					while (inScanner.hasNext()) {
						String type = (String) inScanner.nextLine();

						// JOptionPane.showMessageDialog(null, Mobile);
						/*
						 * if (Mobile.equals(type)) {
						 * 
						 * exist = true; JOptionPane.showMessageDialog(null, "The number  " + type +
						 * ", exist!"); }
						 */
						switch (index) {
						case 1: {
							Name = type;
							break;
						}
						case 2: {
							Email = type;
							break;
						}
						case 3: {
							Occupation = type;
							break;
						}
						case 4: {
							City = type;
							break;
						}
						case 5: {

							if (Mobile.equals(type)) {

								exist = true;
								JOptionPane.showMessageDialog(null, "The number  " + type + ", exist!");

								txfTravelerName.setText(Name);
								cbxCityFrom.setValue(City);
								txfEmailId.setText(Email);
								cbxOccupation.setValue(Occupation);
								txfMobileNo.setText(Mobile);
							}

							break;
						}
						default:
							index = 0;

						}

						index++;
					}

					inScanner.close();

					if (exist == false) {
						JOptionPane.showMessageDialog(null, "Traveller is not found");
					}

				} catch (FileNotFoundException e1) {
					// TODO Auto-generated catch block
					e1.printStackTrace();
				}

			}

		};

		btnSearch.setOnAction(eventSearch);

		Button btnSave = new Button("Save");

		Alert a = new Alert(AlertType.NONE);
		EventHandler<ActionEvent> eventSave = new EventHandler<ActionEvent>() { // Event for save button
			public void handle(ActionEvent e) {
				// TODO Auto-generated method stub
				String TravellerName = txfTravelerName.getText();
				String Mobile = txfMobileNo.getText();
				String Email = txfEmailId.getText();
				String City = cbxCityFrom.getValue();
				String Ocuppation = cbxOccupation.getValue();

				try {
					PrintWriter printWriter = new PrintWriter("TravellerInfo.txt");

					printWriter.println(TravellerName);
					printWriter.println(Email);
					printWriter.println(Ocuppation);
					printWriter.println(City);
					printWriter.println(Mobile);

					printWriter.close();

					JOptionPane.showMessageDialog(null, "Successfully Saved The Details");

				} catch (Exception f) {
					System.out.println(f.getMessage());

					JOptionPane.showMessageDialog(null, "Error when try to write file." + f.getMessage());

				}

			}

		};

		btnSave.setOnAction(eventSave);

		// Create Horizontal panels

		HBox hbox7 = new HBox(10, lbMobileNo, txfMobileNo);
		hbox7.getStyleClass().add("hbox-Panel-Left");

		HBox hbox6 = new HBox(10, lbCytyFrom, cbxCityFrom);
		hbox6.getStyleClass().add("hbox-Panel-Left");

		HBox hbox5 = new HBox(10, lbOcupation, cbxOccupation);
		hbox5.getStyleClass().add("hbox-Panel-Left");

		HBox hbox4 = new HBox(10, lbEmailId, txfEmailId);
		hbox4.getStyleClass().add("hbox-Panel-Left");

		HBox hbox3 = new HBox(10, lbTravelerName, txfTravelerName);
		hbox3.getStyleClass().add("hbox-Panel-Left");

		HBox hbox2 = new HBox(30, btnSave, btnClose, btnSearch); // Insert Buttons
		hbox2.getStyleClass().add("hbox2-x");

		// Create vertical panels
		VBox vbox3 = new VBox(30, hbox6, hbox7);
		vbox3.getStyleClass().add("VBox-Panel1");

		VBox vbox2 = new VBox(30, hbox3, hbox4, hbox5);
		vbox2.getStyleClass().add("VBox-Panel2");

		// Add components to main panel horizontal
		HBox hbox1 = new HBox(30, vbox2, vbox3);

		// Add components to main panel veertical
		VBox vbox1 = new VBox(10, hbox1, hbox2);

		// Creation gridPanel
		GridPane gridPane = new GridPane();

		gridPane.add(vbox1, 0, 0);

		Scene scene = new Scene(gridPane, 800, 400);

		scene.getStylesheets().add(getClass().getResource("application.css").toExternalForm());

		stage.setScene(scene);
		stage.setTitle("Traveller Detail Form ");

		stage.show();

	}

	public static void main(String[] args) {
		// TODO Auto-generated method stub
		launch(args);
	}

}
