package application;

import javafx.application.Application;
import javafx.geometry.Insets;
import javafx.geometry.Pos;
import javafx.scene.Scene;
import javafx.scene.control.Button;
import javafx.scene.control.PasswordField;
import javafx.scene.control.TextField;
import javafx.scene.layout.GridPane;
import javafx.scene.text.Text;
import javafx.stage.Stage;

public class CSSExample extends Application{
	
	public void start (Stage stage) {
		Text text1 = new Text("Email");
		Text text2 = new Text("Password");
		
		TextField textField = new TextField();
		
		PasswordField passwordField = new PasswordField();
		
		Button button1 = new Button("Submit");
		Button button2 = new Button("Clear");
		
		GridPane gridPane = new GridPane();
		
		gridPane.setMinSize(400, 200);
		gridPane.setPadding(new Insets(10,10,10,10));
		
		gridPane.setVgap(5);
		gridPane.setHgap(5);
		
		gridPane.setAlignment(Pos.CENTER);
		
		gridPane.add(text1, 0,0);
		gridPane.add(textField, 1, 0);

		gridPane.add(text2, 0, 1);
		gridPane.add(passwordField, 1, 1);
		
		gridPane.add(button1, 0, 2);
		gridPane.add(button2, 1, 2);
		
		Scene scene = new Scene(gridPane);
		
		scene.getStylesheets().add(getClass().getResource("stylesheet.css").toExternalForm());
		
		
		stage.setTitle("CSS Example");
		
		stage.setScene(scene);
		
		stage.show();
		
	}
	
	public static void main(String args[]) {

		launch(args);
				
	}

}
