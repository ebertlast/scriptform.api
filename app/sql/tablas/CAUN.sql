/*Causal Novedad*/
IF OBJECT_ID('CAUN','U') IS NOT NULL DROP TABLE CAUN
GO
CREATE TABLE [dbo].[CAUN](
	[CausalID] [varchar](9) NOT NULL,
	[DescripcionCausal] [varchar](200) NOT NULL,
)
GO
ALTER TABLE [dbo].[CAUN] ADD CONSTRAINT [CAUNCausalID] PRIMARY KEY CLUSTERED ([CausalID] ASC)



